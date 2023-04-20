<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangRequest;
use App\Models\Barang;
use DataTables;

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
            'total'
        )
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-success">Edit</button>
                        <button type="button" class="btn btn-sm btn-info btnView" data-target=".modalTemplate" data-id="' . $row->id . '" data-toggle="modal">Lihat</button>
                    </div>
                ';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // * Method for store data barang
    public function store(BarangRequest $req)
    {
        $nama      = $req->nama;
        $merk      = $req->merk;
        $total     = $req->total;
        $namaItem  = $req->namaItem;
        $hargaItem = $req->hargaItem;

        $create = array(
            'nama'  => $nama,
            'merk'  => $merk,
            'total' => $total,
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

        return redirect()->route('barang.index')->with('status', 'Tambah Barang Berhasil');
    }

    // * Method for view data barang
    public function show($id)
    {
        $data = Barang::find($id);

        return response()->json($data);
    }

    // * Method for update data barang
    public function update(BarangRequest $req, $id)
    {
        $nama  = $req->nama;
        $merk  = $req->merk;
        $total = $req->total;

        $update = array(
            'nama'  => $nama,
            'merk'  => $merk,
            'total' => $total,
        );

        Barang::where('id', $id)
            ->update($update);

        return back()->with('status', 'Edit Barang Berhasil');
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
}
