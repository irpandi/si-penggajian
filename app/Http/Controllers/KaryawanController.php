<?php

namespace App\Http\Controllers;

use App\Http\Requests\KaryawanRequest;
use App\Http\Service\General;
use App\Models\Karyawan;
use DataTables;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = array(
            'title'       => 'Data Karyawan',
            'breadcrumbs' => '<li class="breadcrumb-item">Data Karyawan</li>',
        );

        return view('karyawan.index', compact('data'));
    }

    // * Method for dataTables
    public function dataTables()
    {
        $data = Karyawan::select(
            'id',
            'nama',
            'tempat_lahir',
            'tgl_lahir',
            'status'
        )
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-success">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger">Delete</button>
                        <button type="button" class="btn btn-sm btn-warning">Non Aktif</button>
                    </div>
                ';

                return $btn;
            })
            ->editColumn('status', function ($row) {
                $status = 'Tidak diketahui';

                if ($row->status == 1) {
                    $status = "Aktif";
                } else if ($row->status == 0) {
                    $status = 'Non Aktif';
                }

                return $status;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // * Method for add data karyawan
    public function store(KaryawanRequest $req)
    {
        $nik          = $req->nik;
        $nameKaryawan = $req->nameKaryawan;
        $tmptLahir    = $req->tmptLahir;
        $tglLahir     = General::manageDate('d/m/Y', $req->tglLahir, 'Y-m-d');
        $status       = $req->status;
        $noHp         = $req->noHp;
        $alamat       = $req->alamat;

        $create = array(
            'nik'          => $nik,
            'nama'         => $nameKaryawan,
            'tempat_lahir' => $tmptLahir,
            'tgl_lahir'    => $tglLahir,
            'status'       => $status,
            'no_hp'        => $noHp,
            'alamat'       => $alamat,
        );

        Karyawan::create($create);

        return back()->with('status', 'Tambah Karyawan Berhasil');
    }
}
