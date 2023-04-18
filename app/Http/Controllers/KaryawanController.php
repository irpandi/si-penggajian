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
                        <button type="button" class="btn btn-sm btn-success btnEdit" data-target=".modalTemplate" data-id="' . $row->id . '" data-toggle="modal">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger btnDelete" data-id="' . $row->id . '">Delete</button>
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

    // * Method for view data karyawan
    public function view($id)
    {
        $data = Karyawan::find($id);

        return response()->json($data);
    }

    // * Method for update data karyawan
    public function update(KaryawanRequest $req, $id)
    {
        $nik          = $req->nik;
        $nameKaryawan = $req->nameKaryawan;
        $tmptLahir    = $req->tmptLahir;
        $tglLahir     = General::manageDate('d/m/Y', $req->tglLahir, 'Y-m-d');
        $status       = $req->status;
        $noHp         = $req->noHp;
        $alamat       = $req->alamat;

        $update = array(
            'nik'          => $nik,
            'nama'         => $nameKaryawan,
            'tempat_lahir' => $tmptLahir,
            'tgl_lahir'    => $tglLahir,
            'status'       => $status,
            'no_hp'        => $noHp,
            'alamat'       => $alamat,
        );

        Karyawan::where('id', $id)
            ->update($update);

        return back()->with('status', 'Edit Karyawan Berhasil');
    }

    // * Method for soft delete karyawan & aktif / non-aktif karyawan.
    public function destroy($id)
    {
        $message    = 'Berhasil hapus karyawan';
        $iconStatus = 'success';
        $code       = 200;

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        $response = array(
            'message'    => $message,
            'iconStatus' => $iconStatus,
        );

        return response()->json($response, $code);
    }
}
