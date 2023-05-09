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
                        <button type="button" class="btn btn-sm btn-danger btnDestroyTunjangan" data-id="' . $row->id . '">Delete</button>
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
        $totalGajiId     = $req->totalGajiId;
        $namaTunjangan   = $req->namaTunjangan;
        $jumlahTunjangan = $req->jumlahTunjangan;

        // * Data Before
        $tunjangan = Tunjangan::findOrFail($id);
        $totalGaji = TotalGaji::findOrFail($totalGajiId);

        $beforeJumlahTunjangan = $tunjangan->jumlah;

        if ($beforeJumlahTunjangan > $jumlahTunjangan) {
            $selisihTunjangan = $beforeJumlahTunjangan - $jumlahTunjangan;
            $totalTunjangan   = $beforeJumlahTunjangan - $selisihTunjangan;
        } else if ($beforeJumlahTunjangan < $jumlahTunjangan) {
            $selisihTunjangan = $jumlahTunjangan - $beforeJumlahTunjangan;
            $totalTunjangan   = $beforeJumlahTunjangan + $selisihTunjangan;
        } else {
            $selisihTunjangan = $beforeJumlahTunjangan;
            $totalTunjangan   = $beforeJumlahTunjangan;
        }

        Tunjangan::where('id', $tunjangan->id)
            ->update([
                'nama'   => $namaTunjangan,
                'jumlah' => $totalTunjangan,
            ]);

        // * Manage Total Gaji
        TransaksiItemService::manageTotalGaji($totalGaji->periode_id, $totalGaji->karyawan_id);

        return back()->with([
            'message' => 'Data Tunjangan berhasil diupdate',
            'icon'    => 'success',
            'title'   => 'Sukses',
        ]);
    }

    public function destroy($id)
    {
        $message    = 'Berhasil delete tunjangan';
        $iconStatus = 'success';
        $code       = 200;

        $tunjangan   = Tunjangan::find($id);
        $totalGajiId = $tunjangan->total_gaji_id;
        $tunjangan->delete();

        $totalGaji = TotalGaji::find($totalGajiId);

        // * Manage Total Gaji
        TransaksiItemService::manageTotalGaji($totalGaji->periode_id, $totalGaji->karyawan_id);

        $response = array(
            'message'    => $message,
            'iconStatus' => $iconStatus,
        );

        return response()->json($response, $code);
    }
}
