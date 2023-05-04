<?php

// * Author By : Rifki Irpandi

namespace App\Http\Controllers;

use App\Http\Requests\PenggajianRequest;
use App\Http\Service\General;
use App\Http\Service\TransaksiItemService;
use App\Models\Barang;
use App\Models\DataGaji;
use App\Models\Item;
use App\Models\Karyawan;
use App\Models\Periode;
use App\Models\SubItem;
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
            'tbl_periode.id as periode_id',
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
                    <a href="' . route('penggajian.show', ['karyawanId' => $row->id, 'periodeId' => $row->periode_id]) . '" class="btn btn-sm btn-info">Lihat</a>
                ';

                return $btn;
            })
            ->editColumn('tgl_periode', function ($row) {
                $newDate = General::manageDate('Y-m-d', $row->tgl_periode, 'd/m/Y');

                return $newDate;
            })
            ->editColumn('total', function ($row) {
                $numberFormat = number_format($row->total, 0, ",", ".");

                return $numberFormat;
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
                ->where('status', 1)
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

    // * Method for add data pernggajian
    public function store(PenggajianRequest $req)
    {
        $tglPeriode          = $req->tglPeriode;
        $karyawan            = $req->karyawan;
        $barang              = $req->barang;
        $item                = $req->item;
        $totalPengerjaanItem = $req->totalPengerjaanItem;

        $dataReq = array(
            'tglPeriode'          => $tglPeriode,
            'karyawan'            => $karyawan,
            'barang'              => $barang,
            'item'                => $item,
            'totalPengerjaanItem' => $totalPengerjaanItem,
        );

        $result = TransaksiItemService::storePenggajian($dataReq);

        if ($result == TransaksiItemService::$msgPengerjaanItem) {
            return back()->with([
                'message' => 'Item pengerjaan pada data item telah habis',
                'icon'    => 'warning',
                'title'   => 'Warning',
            ]);
        } else if ($result == TransaksiItemService::$msgTmpBarangNol) {
            return back()->with([
                'message' => 'Item ini sudah habis',
                'icon'    => 'warning',
                'title'   => 'warning',
            ]);
        }

        return redirect()->route('penggajian.index')->with([
            'message' => 'Tambah data penggajian berhasil',
            'icon'    => 'success',
            'title'   => 'Sukses',
        ]);
    }

    // * Method for show page data penggajian karyawan
    public function show($karyawanId, $periodeId)
    {
        $karyawan = Karyawan::where('id', $karyawanId)
            ->with('totalGaji', function ($q) use ($periodeId) {
                $q->where('periode_id', $periodeId);
            })
            ->first();

        $periode = Periode::findOrfail($periodeId);

        $data = array(
            'title'       => 'Lihat Data Penggajian',
            'breadcrumbs' => '
                <li class="breadcrumb-item"><a href="/penggajian">Data Penggajian</a></li>
                <li class="breadcrumb-item active">Lihat Data</li>
            ',
            'karyawan'    => $karyawan,
            'periode'     => $periode,
        );

        return view('penggajian.show', compact('data'));
    }

    // * Method for show data gaji in page lihat data penggajian
    public function dataTablesGaji(Request $req)
    {
        $periodeId  = $req->periodeId;
        $karyawanId = $req->karyawanId;

        $data = SubItem::select(
            'tbl_sub_item.id',
            'tbl_item.nama as nama_item',
            'tbl_barang.nama as nama_barang',
            'tbl_item.harga as harga_item',
            'tbl_sub_item.total_pengerjaan_item',
            'tbl_barang.merk as merk_barang',
            'tbl_data_gaji.id as data_gaji_id'
        )
            ->join('tbl_item', 'tbl_item.id', '=', 'tbl_sub_item.item_id')
            ->join('tbl_barang', 'tbl_barang.id', '=', 'tbl_item.barang_id')
            ->join('tbl_data_gaji', 'tbl_data_gaji.sub_item_id', '=', 'tbl_sub_item.id')
            ->where([
                ['tbl_sub_item.periode_id', '=', $periodeId],
                ['tbl_data_gaji.karyawan_id', '=', $karyawanId],
            ])
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                    <div class="btn-group">
                        <a href="' . route('penggajian.edit', $row->data_gaji_id) . '" class="btn btn-sm btn-success">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger">Hapus</button>
                    </div>
                ';

                return $btn;
            })
            ->editColumn('harga_item', function ($row) {
                $harga = 'Rp. ' . number_format($row->harga_item, 0, ',', '.');

                return $harga;
            })
            ->editColumn('nama_barang', function ($row) {
                $nama = $row->merk_barang . ' | ' . $row->nama_barang;

                return $nama;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // * Method for show page edit data penggajian
    public function edit($id)
    {
        $dataGaji = DataGaji::where('id', $id)
            ->with([
                'subItem',
                'subItem.periode',
                'subItem.item',
                'subItem.item.barang',
                'karyawan',
            ])
            ->first();

        $data = array(
            'title'       => 'Edit Data',
            'breadcrumbs' => '
                <li class="breadcrumb-item"><a href="' . route('penggajian.index') . '">Data Penggajian</a></li>
                <li class="breadcrumb-item"><a href="' . route('penggajian.show', ['karyawanId' => $dataGaji->karyawan_id, 'periodeId' => $dataGaji->subItem->periode_id]) . '">Lihat Data Penggajian</a></li>
                <li class="breadcrumb-item active">Edit Data</li>
            ',
            'dataGaji'    => $dataGaji,
        );

        return view('penggajian.edit', compact('data'));
    }

    // * Method for update data penggajian
    public function update(PenggajianRequest $req, $id)
    {
        $tglPeriode          = $req->tglPeriode;
        $karyawan            = $req->karyawan;
        $barang              = $req->barang;
        $item                = $req->item;
        $totalPengerjaanItem = $req->totalPengerjaanItem;

        $dataReq = array(
            'subItemId'           => $id,
            'tglPeriode'          => $tglPeriode,
            'karyawan'            => $karyawan,
            'barang'              => $barang,
            'item'                => $item,
            'totalPengerjaanItem' => $totalPengerjaanItem,
        );

        $result = TransaksiItemService::updatePenggajian($dataReq);

        if ($result == TransaksiItemService::$msgPengerjaanItem) {
            return back()->with([
                'message' => 'Item pengerjaan pada data item telah habis',
                'icon'    => 'warning',
                'title'   => 'Warning',
            ]);
        } else if ($result == TransaksiItemService::$msgTmpBarangNol) {
            return back()->with([
                'message' => 'Item ini sudah habis',
                'icon'    => 'warning',
                'title'   => 'warning',
            ]);
        }

        return back()->with([
            'message' => 'Edit data penggajian berhasil',
            'icon'    => 'success',
            'title'   => 'Sukses',
        ]);
    }
}
