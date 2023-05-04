<?php

// * Author By : Rifki Irpandi

namespace App\Http\Service;

use App\Models\DataGaji;
use App\Models\Item;
use App\Models\SubItem;
use App\Models\TotalGaji;
use App\Models\TransaksiItem;

class TransaksiItemService
{
    public static $msgTransaksiItemTambah    = 'item_menambah_to_sub_item';
    public static $msgTransaksiItemKurang    = 'sub_item_mengurangi_to_item';
    public static $msgTransaksiSubItemTambah = 'sub_item_menambah_to_item';
    public static $msgTransaksiSubItemKurang = 'item_mengurangi_to_sub_item';
    public static $msgAnomali                = 'anomali';
    public static $msgPengerjaanItem         = 'not_valid_total_pengerjaan_item';
    public static $msgTmpBarangNol           = 'nol_tmp_barang';
    public static $msgValidItem              = 'valid_total_pengerjaan_item';
    public static $msgStore                  = 'store';
    public static $msgUpdate                 = 'update';

    // * Manage store to database for add penggajian
    public static function storePenggajian($data)
    {
        $tglPeriode          = $data['tglPeriode'];
        $karyawan            = $data['karyawan'];
        $barang              = $data['barang'];
        $item                = $data['item'];
        $totalPengerjaanItem = $data['totalPengerjaanItem'];

        // * Validation custom for item
        $validItem = self::validationItem($item, $totalPengerjaanItem);
        if ($validItem == self::$msgPengerjaanItem) {
            return self::$msgPengerjaanItem;
        } else if ($validItem == self::$msgTmpBarangNol) {
            return self::$msgTmpBarangNol;
        }

        $item = Item::findOrFail($item);

        // * Create sub item data for penggajian
        $createSubItem = SubItem::create([
            'periode_id'            => $tglPeriode,
            'item_id'               => $item->id,
            'total_pengerjaan_item' => $totalPengerjaanItem,
        ]);

        // * Create transactions for tmp barang
        $dataTrx = [
            'itemId'    => $item->id,
            'subItemId' => $createSubItem->id,
        ];
        $dataTrx['beforeTmp'] = $item->total_tmp_barang;

        $penguranganItem = $item->total_tmp_barang - $totalPengerjaanItem;
        Item::where('id', $item->id)
            ->update([
                'total_tmp_barang' => $penguranganItem,
            ]);
        $dataAfterItem = Item::findOrFail($item->id);

        $dataTrx['afterTmp']   = $dataAfterItem->total_tmp_barang;
        $dataTrx['selisihTmp'] = $totalPengerjaanItem;

        self::transaksiPenggajian($dataTrx, self::$msgTransaksiItemTambah);
        self::transaksiPenggajian($dataTrx, self::$msgTransaksiItemKurang);

        // * Create data gaji for karyawan
        DataGaji::create([
            'karyawan_id' => $karyawan,
            'sub_item_id' => $createSubItem->id,
        ]);

        // * Hitung total gaji
        self::manageTotalGaji($tglPeriode, $karyawan);

        return self::$msgStore;
    }

    // * Manage transaksi penggajian
    private static function transaksiPenggajian($data, $msg)
    {
        $itemId     = $data['itemId'];
        $subItemId  = $data['subItemId'];
        $beforeTmp  = $data['beforeTmp'];
        $afterTmp   = $data['afterTmp'];
        $selisihTmp = $data['selisihTmp'];

        $createTransaksi = [
            'item_id'                  => $itemId,
            'sub_item_id'              => $subItemId,
            'keterangan'               => self::$msgAnomali,
            'before_total_tmp_barang'  => $beforeTmp,
            'after_total_tmp_barang'   => $afterTmp,
            'selisih_total_tmp_barang' => $selisihTmp,
        ];

        if ($msg == self::$msgTransaksiItemTambah) {
            $createTransaksi['keterangan'] = self::$msgTransaksiItemTambah;
        } else if ($msg == self::$msgTransaksiItemKurang) {
            $createTransaksi['keterangan'] = self::$msgTransaksiItemKurang;
        } else if ($msg == self::$msgTransaksiSubItemTambah) {
            $createTransaksi['ketarangan'] = self::$msgTransaksiSubItemTambah;
        } else if ($msg == self::$msgTransaksiSubItemKurang) {
            $createTransaksi['keterangan'] = self::$msgTransaksiSubItemKurang;
        }

        TransaksiItem::create($createTransaksi);
    }

    // * Manage validation total item
    private static function validationItem($itemId, $totalPengerjaanItem)
    {
        $item = Item::findOrFail($itemId);

        if ($item) {
            if ($totalPengerjaanItem > $item->total_tmp_barang) { // * Validasi jika input total pengerjaan item > total tmp barang
                return self::$msgPengerjaanItem;
            } else if ($item->total_tmp_barang == 0) { // * Validasi jika tmp barang pada item = 0
                return self::$msgTmpBarangNol;
            }
        }

        return self::$msgValidItem;
    }

    // * Method for manage total gaji karyawan
    public static function manageTotalGaji($periodeId, $karyawanId)
    {
        $dataGaji = DataGaji::select(
            'tbl_data_gaji.id',
            'tbl_sub_item.total_pengerjaan_item',
            'tbl_item.harga'
        )
            ->join('tbl_sub_item', 'tbl_sub_item.id', '=', 'tbl_data_gaji.sub_item_id')
            ->join('tbl_item', 'tbl_item.id', '=', 'tbl_sub_item.item_id')
            ->where([
                'tbl_data_gaji.karyawan_id' => $karyawanId,
                'tbl_sub_item.periode_id'   => $periodeId,
            ])
            ->get();

        if (count($dataGaji) > 0) {
            $pengerjaanItemGaji = array();
            foreach ($dataGaji as $value) {
                $jmlhPengerjaanItem = $value->total_pengerjaan_item * $value->harga;
                array_push($pengerjaanItemGaji, $jmlhPengerjaanItem);
            }

            $totalGaji = array_sum($pengerjaanItemGaji);
            TotalGaji::updateOrCreate([
                'karyawan_id' => $karyawanId,
                'periode_id'  => $periodeId,
            ], [
                'total' => $totalGaji,
            ]);
        }
    }

    // * Manage update to database for edit penggajian
    public static function updatePenggajian($data)
    {
        $subItemId           = $data['subItemId'];
        $tglPeriode          = $data['tglPeriode'];
        $karyawan            = $data['karyawan'];
        $barang              = $data['barang'];
        $item                = $data['item'];
        $totalPengerjaanItem = $data['totalPengerjaanItem'];

        // * Validation custom for item
        $validItem = self::validationItem($item, $totalPengerjaanItem);
        if ($validItem == self::$msgPengerjaanItem) {
            return self::$msgPengerjaanItem;
        } else if ($validItem == self::$msgTmpBarangNol) {
            return self::$msgTmpBarangNol;
        }

        // * Data before
        $item    = Item::findOrFail($item);
        $subItem = SubItem::findOrFail($subItemId);

        $dataTrx = [
            'itemId'    => $item->id,
            'subItemId' => $subItem->id,
        ];

        $beforeTotalPengerjaanItem = $subItem->total_pengerjaan_item;
        $tmpBarang                 = $item->total_tmp_barang;

        if ($beforeTotalPengerjaanItem < $totalPengerjaanItem) {
            $selisihTmpBarang = $totalPengerjaanItem - $beforeTotalPengerjaanItem;
            $totalTmpBarang   = $tmpBarang - $selisihTmpBarang;
        } else if ($beforeTotalPengerjaanItem > $totalPengerjaanItem) {
            $selisihTmpBarang = $beforeTotalPengerjaanItem - $totalPengerjaanItem;
            $totalTmpBarang   = $tmpBarang + $selisihTmpBarang;
        } else {
            $selisihTmpBarang = $beforeTotalPengerjaanItem;
            $totalTmpBarang   = $tmpBarang;
        }

        Item::where('id', $item->id)
            ->update([
                'total_tmp_barang' => $totalTmpBarang,
            ]);

        SubItem::where('id', $subItem->id)
            ->update([
                'total_pengerjaan_item' => $totalPengerjaanItem,
            ]);

        return self::$msgUpdate;
    }
}
