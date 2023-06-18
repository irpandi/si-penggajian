<?php

// * Author By : Rifki Irpandi

namespace App\Http\Controllers;

use App\Http\Requests\BarangRequest;
use App\Http\Service\General;
use App\Models\Barang;
use App\Models\Item;
use App\Models\SubItem;
use DataTables;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $data = array(
            'title'       => 'Data Barang',
            'breadcrumbs' => '<li class="breadcrumb-item">Data Barang</li>',
        );

        return view('barang.index', compact('data'));
    }

    // * Method for dataTables
    public function dataTables()
    {
        $data = Barang::select(
            'id',
            'nama',
            'merk',
            'total',
            'periode_id'
        )
            ->with(['periode'])
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                    <div class="btn-group">
                        <a class="btn btn-sm btn-success" href="' . route('barang.edit', $row->id) . '">Edit</a>
                        <button type="button" class="btn btn-sm btn-info btnView" data-target=".modalTemplate" data-id="' . $row->id . '" data-toggle="modal">Lihat</button>
                        <a class="btn btn-sm btn-warning btnCopy" data-id="' . $row->id . '" data-toggle="modal" href="#">Copy</a>
                    </div>
                ';

                return $btn;
            })
            ->editColumn('periode.tgl_periode', function ($row) {
                $date = General::manageDate('Y-m-d', $row->periode->tgl_periode, 'd/m/Y');

                return $date;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // * Method for store data barang
    public function store(BarangRequest $req)
    {
        $tglPeriode = $req->tglPeriode;
        $nama       = $req->nama;
        $merk       = $req->merk;
        $total      = $req->total;
        $namaItem   = $req->namaItem;
        $hargaItem  = $req->hargaItem;

        $create = array(
            'periode_id' => $tglPeriode,
            'nama'       => $nama,
            'merk'       => $merk,
            'total'      => $total,
        );

        $barang = Barang::create($create);

        if (count($namaItem) > 0) {
            $batchItem = array();
            for ($i = 0; $i < count($namaItem); $i++) {
                $item = array(
                    'barang_id'        => $barang->id,
                    'nama'             => $namaItem[$i],
                    'harga'            => $hargaItem[$i],
                    'total_tmp_barang' => $total,
                );

                array_push($batchItem, $item);
            }

            $barang->item()->createMany($batchItem);
        }

        return redirect()->route('barang.index')->with([
            'message' => 'Tambah Barang Berhasil',
            'icon'    => 'success',
            'title'   => 'Sukses',
        ]);
    }

    // * Method for view data barang
    public function show(Request $req, $id)
    {
        $data = Barang::where('id', $id)
            ->with(['periode', 'item'])
            ->first();

        if ($req->dataTables) {
            $item = $data->item;

            return DataTables::of($item)
                ->addIndexColumn()
                ->editColumn('harga', function ($row) {
                    $harga = General::formaterNumber($row->harga, 0);

                    return $harga;
                })
                ->make(true);
        }

        return response()->json($data);
    }

    // * Method for update data barang
    public function update(BarangRequest $req, $id)
    {
        $nama            = $req->nama;
        $merk            = $req->merk;
        $total           = $req->total;
        $namaItem        = $req->namaItem;
        $hargaItem       = $req->hargaItem;
        $itemId          = $req->itemId;
        $namaItemUpdate  = $req->namaItemUpdate;
        $hargaItemUpdate = $req->hargaItemUpdate;

        $update = array(
            'nama'  => $nama,
            'merk'  => $merk,
            'total' => $total,
        );

        $barangUpdate = Barang::findOrFail($id);

        // * Untuk pengecekan total pengeluaran item yang dipakai oleh tbl_sub_item
        if ($total != $barangUpdate->total) {
            $valid = $this->validationEditBarang('edit_total_barang', $id);
            if (!$valid) {
                return back()->with([
                    'message' => 'Edit Data Barang Gagal',
                    'icon'    => 'warning',
                    'title'   => 'Gagal',
                ]);
            }
        }

        if ($total != $barangUpdate->total) {
            // * Update total_tmp_barang di tbl_item, jika total barang tidak sama dengan request total yg dikirim
            $barangUpdate->item()->update([
                'total_tmp_barang' => $total,
            ]);
        }

        $barangUpdate->update($update);

        // * Condition for update item
        if ($itemId && count($itemId) > 0) {
            for ($i = 0; $i < count($itemId); $i++) {
                $barangUpdate->item()
                    ->where('id', $itemId[$i])
                    ->update([
                        'nama'  => $namaItemUpdate[$i],
                        'harga' => $hargaItemUpdate[$i],
                    ]);
            }
        }

        // * Condition for new item (create data item)
        if ($namaItem && count($namaItem) > 0) {
            $batchItem = array();
            for ($i = 0; $i < count($namaItem); $i++) {
                $item = array(
                    'barang_id'        => $barangUpdate->id,
                    'nama'             => $namaItem[$i],
                    'harga'            => $hargaItem[$i],
                    'total_tmp_barang' => $total,
                );

                array_push($batchItem, $item);
            }

            $barangUpdate->item()->createMany($batchItem);
        }

        return redirect()->route('barang.index')->with([
            'message' => 'Edit Barang Berhasil',
            'icon'    => 'success',
            'title'   => 'Sukses',
        ]);
    }

    // * Method for show page create data barang
    public function create()
    {
        $data = array(
            'title'       => 'Tambah Data',
            'breadcrumbs' => '
                <li class="breadcrumb-item"><a href="/barang">Data Barang</a></li>
                <li class="breadcrumb-item active">Tambah Data</li>
            ',
        );

        return view('barang.create', compact('data'));
    }

    // * Method for show page edit data barang
    public function edit($id)
    {
        $barang = Barang::find($id);

        $data = array(
            'title'       => 'Edit Data',
            'breadcrumbs' => '
                <li class="breadcrumb-item"><a href="/barang">Data Barang</a></li>
                <li class="breadcrumb-item active">Edit Data</li>
            ',
            'barang'      => $barang,
        );

        return view('barang.edit', compact('data'));
    }

    // * Method for delete item on edit data barang page
    public function destroyItem($id)
    {
        $message    = 'Berhasil hapus data item';
        $iconStatus = 'success';
        $code       = 200;

        $item = Item::findOrFail($id);

        // * Untuk pengecekan total pengeluaran item yang dipakai oleh tbl_sub_item
        $valid = $this->validationEditBarang('hapus_item', $id);
        if (!$valid) {
            $message    = 'Gagal hapus data item';
            $iconStatus = 'warning';
            $code       = 400;
        } else {
            $item->delete();
        }

        $response = array(
            'message'    => $message,
            'iconStatus' => $iconStatus,
        );

        return response()->json($response, $code);
    }

    // * Method for validation custom edit data barang
    private function validationEditBarang($cond, $customId)
    {
        $status = true;

        if ($cond == 'hapus_item') {
            $data = SubItem::where('item_id', $customId)
                ->count();

            if ($data > 0) {
                $status = false;
            }
        } else if ($cond == 'edit_total_barang') {
            $data = Item::where('barang_id', $customId)
                ->with('subItem')
                ->get();

            for ($i = 0; $i < count($data); $i++) {
                $subItem = $data[$i]->subItem;

                for ($j = 0; $j < count($subItem); $j++) {
                    // * Jika data item total_tmp_barang sudah ada yg pakai di table sub_item
                    if ($subItem[$j] && $subItem[$j]->total_pengerjaan_item > 0) {
                        $status = false;
                        break;
                    }
                }
            }
        }

        return $status;
    }

    // * Method for copy data barang
    public function copyBarang($id)
    {
        $data    = Barang::find($id);
        $newData = $data->replicateItem();

        return response()->json($id);
    }
}
