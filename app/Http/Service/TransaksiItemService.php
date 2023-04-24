<?php

// * Author By : Rifki Irpandi

namespace App\Http\Service;

use App\Models\Item;
use App\Models\SubItem;
use App\Models\TransaksiItem;

class TransaksiItemService
{
    public static $msgTransaksiItemTambah    = 'item_menambah_to_sub_item';
    public static $msgTransaksiItemKurang    = 'sub_item_mengurangi_to_item';
    public static $msgTransaksiSubItemTambah = 'sub_item_menambah_to_item';
    public static $msgTransaksiSubItemKurang = 'item_mengurangi_to_sub_item';
    public static $msgAnomali                = 'anomali';
    public static $msgPengerjaanItem         = 'not_valid_total_pengerjaan_item';
    public static $msgValidItem              = 'valid_total_pengerjaan_item';
    public static $msgStore                  = 'store';

    // * Manage store to database for add penggajian
    public static function storePenggajian($data)
    {
        $tglPeriode          = $data['tglPeriode'];
        $karyawan            = $data['karyawan'];
        $barang              = $data['barang'];
        $item                = $data['item'];
        $totalPengerjaanItem = $data['totalPengerjaanItem'];

        $validItem = self::validationItem($item, $totalPengerjaanItem);

        if ($validItem == self::$msgPengerjaanItem) {
            return self::$msgPengerjaanItem;
        }

        $item = Item::findOrFail($item);

        $createSubItem = SubItem::create([
            'periode_id'            => $tglPeriode,
            'item_id'               => $item->id,
            'total_pengerjaan_item' => $totalPengerjaanItem,
        ]);

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
            }
        }

        return self::$msgValidItem;
    }
}
