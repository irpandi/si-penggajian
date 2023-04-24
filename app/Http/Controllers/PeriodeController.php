<?php

// * Author By : Rifki Irpandi

namespace App\Http\Controllers;

use App\Http\Requests\PeriodeRequest;
use App\Http\Service\General;
use App\Models\Periode;
use DataTables;

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
        $data = Periode::select('id', 'tgl_periode')
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-sm btn-success btnEditPeriode" data-target=".modal-template" data-id="' . $row->id . '" data-toggle="modal">
                    <i class="fa fa-pencil-alt"></i>
                    Edit
                </button>';

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
    public function store(PeriodeRequest $req)
    {
        $tglPeriode = $req->tglPeriode;

        $create = array(
            'tgl_periode' => $tglPeriode,
        );

        Periode::create($create);

        return back()->with('status', 'Tambah Periode Berhasil');
    }

    // * Method for update periode
    public function update(PeriodeRequest $req, $id)
    {
        $tglPeriode = $req->tglPeriode;

        $update = array(
            'tgl_periode' => $tglPeriode,
        );

        Periode::where('id', $id)
            ->update($update);

        return back()->with('status', 'Edit Periode Berhasil');
    }

    // * Method for view periode
    public function view($id)
    {
        $data = Periode::find($id);

        return response()->json($data);
    }
}
