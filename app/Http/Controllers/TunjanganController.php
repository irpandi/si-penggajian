<?php

namespace App\Http\Controllers;

use App\Http\Requests\TunjanganRequest;
use App\Models\TotalGaji;
use DataTables;
use Illuminate\Http\Request;

class TunjanganController extends Controller
{
    // * Method for add data tunjangan
    public function store(TunjanganRequest $req)
    {
        dd($req);
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
                        <a href="#" class="btn btn-sm btn-success">Edit</a>
                        <button type="button" class="btn-sm btn-danger">Delete</button>
                    </div>
                ';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
