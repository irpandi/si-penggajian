<?php

namespace App\Http\Controllers;

use App\Http\Requests\TunjanganRequest;
use App\Http\Service\General;
use App\Http\Service\TransaksiItemService;
use App\Models\TotalGaji;
use App\Models\Tunjangan;
use DataTables;
use Illuminate\Http\Request;

class TunjanganController extends Controller
{
    // * Method for add data tunjangan
    public function store(TunjanganRequest $req)
    {
        $totalGajiId     = $req->totalGajiId;
        $namaTunjangan   = $req->namaTunjangan;
        $jumlahTunjangan = $req->jumlahTunjangan;

        $totalGaji = TotalGaji::findOrFail($totalGajiId);

        $store = array(
            'total_gaji_id' => $totalGajiId,
            'nama'          => $namaTunjangan,
            'jumlah'        => $jumlahTunjangan,
        );

        Tunjangan::create($store);

        // * Manage Total Gaji
        TransaksiItemService::manageTotalGaji($totalGaji->periode_id, $totalGaji->karyawan_id);

        return back()->with([
            'message' => 'Tambah tunjangan berhasil',
            'title'   => 'Sukses',
            'icon'    => 'success',
        ]);
    }

    // * Method for list data tunjangan
    public function dataTables(Request $req)
    {
        $totalGajiId = $req->totalGajiId;

        $data = TotalGaji::where('id', $totalGajiId)
            ->with(['tunjangan'])
            ->first();

        return DataTables::of($data->tunjangan)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-success btnEditTunjangan" data-id="' . $row->id . '" data-target=".modalTemplateTunjangan" data-toggle="modal">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger">Delete</button>
                    </div>
                ';

                return $btn;
            })
            ->editColumn('jumlah', function ($row) {
                return General::formaterNumber($row->jumlah, 0);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // * Method for get data tunjangan
    public function show($id)
    {
        $data = Tunjangan::findOrFail($id);

        return response()->json($data);
    }

    // * For update data tunjangan
    public function update(TunjanganRequest $req, $id)
    {
        dd($req);
    }
}
