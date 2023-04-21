<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Item;
use App\Models\Karyawan;
use App\Models\Periode;
use App\Models\TotalGaji;
use DataTables;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index()
    {
        $data = array(
            'title'       => 'Data Penggajian',
            'breadcrumbs' => '<li class="breadcrumb-item">Data Penggajian</li>',
        );

        return view('penggajian.index', compact('data'));
    }

    // * Method for dataTables
    public function dataTables()
    {
        $data = TotalGaji::select(
            'tbl_karyawan.id',
            'tbl_periode.tgl_periode',
            'tbl_karyawan.nama',
            'tbl_total_gaji.total'
        )
            ->join('tbl_karyawan', 'tbl_karyawan.id', '=', 'tbl_total_gaji.karyawan_id')
            ->join('tbl_periode', 'tbl_periode.id', '=', 'tbl_total_gaji.periode_id')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                    <a href="#" class="btn btn-sm btn-info">Lihat</a>
                ';

                return $btn;
            })
            ->editColumn('tgl_periode', function ($row) {
                $newDate = General::manageDate('Y-m-d', $row->tgl_periode, 'd/m/Y');

                return $newDate;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // * Method for show page tambah data penggajian
    public function create()
    {
        $data = array(
            'title'       => 'Tambah Data',
            'breadcrumbs' => '
                <li class="breadcrumb-item"><a href="/penggajian">Data Penggajian</a></li>
                <li class="breadcrumb-item active">Tambah Data</li>
            ',
        );

        return view('penggajian.create', compact('data'));
    }

    // * Method for prepare page create penggajian
    public function preparePagePenggajian(Request $req)
    {
        $data = array();

        if ($req->type == 'periode') {
            $data = Periode::select(
                'id',
                'tgl_periode'
            )
                ->get();
        } else if ($req->type == 'karyawan') {
            $data = Karyawan::select(
                'id',
                'nama'
            )
                ->get();
        } else if ($req->type == 'barang') {
            $data = Barang::select(
                'id',
                'nama',
                'merk'
            )
                ->get();
        } else if ($req->type == 'item' && $req->barangId != '') {
            $data = Item::select(
                'id',
                'nama'
            )
                ->where('barang_id', $req->barangId)
                ->get();
        }

        return response()->json($data);
    }
}
