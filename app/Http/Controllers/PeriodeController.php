<?php

namespace App\Http\Controllers;

use App\Http\Service\General;
use App\Models\Periode;
use DataTables;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $data = array(
            'title'       => 'Data Periode',
            'breadcrumbs' => '<li class="breadcrumb-item">Data Periode</li>',
        );

        return view('periode.index', compact('data'));
    }

    // * Method for dataTables
    public function dataTables()
    {
        $data = Periode::select('tgl_periode')
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="#" class="btn btn-sm btn-success">
                    <i class="fa fa-pencil-alt"></i>
                    Edit
                </a>';

                return $btn;
            })
            ->editColumn('tgl_periode', function ($row) {
                $newDate = General::manageDate('Y-m-d', $row->tgl_periode, 'd/m/Y');

                return $newDate;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // * Method for add periode
    public function store(Request $req)
    {
        $req->validate([
            'tglPeriode' => 'required',
        ]);

        $tglPeriode = $req->tglPeriode;
        $newDate    = General::manageDate('d/m/Y', $tglPeriode, 'Y-m-d');

        Periode::create([
            'tgl_periode' => $newDate,
        ]);

        return redirect()->back();
    }
}
