@extends('layouts.home', [
    'title' => $data['title'],
    'breadcrumbs' => $data['breadcrumbs']
])

@section('modal')
    {{-- Modal Template Tunjangan --}}
    <div class="modal fade modalTemplateTunjangan">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleModal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="formTemplateTunjangan">
                        @csrf
                        <input type="hidden" name="_method" id="method">

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Nama Tunjangan" id="namaTunjangan" name="namaTunjangan">
                            <div class="input-group-text">
                                <i class="fas fa-table"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Jumlah Tunjangan" id="jumlahTunjangan" name="jumlahTunjangan">
                            <div class="input-group-text">
                                <i class="fas fa-table"></i>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-sm btn-primary" id="btnSaveTunjangan">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="container">
            <input type="hidden" id="karyawanId" value="{{ $data['karyawan']->id }}">
            <input type="hidden" id="periodeId" value="{{ $data['periode']->id }}">
            <div class="row">
                {{-- Data Karyawan --}}
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Data Karyawan</h4>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td>{{ $data['karyawan']->nik }}</td>
                                </tr>

                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $data['karyawan']->nama }}</td>
                                </tr>

                                <tr>
                                    <td>Tempat, Tanggal Lahir</td>
                                    <td>:</td>
                                    <td>{{ $data['karyawan']->tempat_lahir }}, {{ App\Http\Service\General::manageDate('Y-m-d', $data['karyawan']->tgl_lahir, 'd/m/Y') }}</td>
                                </tr>

                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>
                                        @if($data['karyawan']->status == 1)
                                            Aktif
                                        @else
                                            Non Aktif
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>Periode</td>
                                    <td>:</td>
                                    <td>{{ App\Http\Service\General::manageDate('Y-m-d', $data['periode']->tgl_periode, 'd/m/Y') }}</td>
                                </tr>

                                <tr>
                                    <td>Total Gaji</td>
                                    <td>:</td>
                                    <td>{{ number_format($data['karyawan']->totalGaji->total, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Data Gaji --}}
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Data Gaji</h4>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="tblGaji" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Barang</th>
                                        <th>Item</th>
                                        <th>Harga</th>
                                        <th>Total Pengerjaan Item</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Data Tunjangan --}}
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Data Tunjangan</h4>
                            </div>

                            <div class="card-tools">
                                <a href="#" class="btn btn-sm btn-primary" id="btnTambahTunjangan" data-target=".modalTemplateTunjangan" data-toggle="modal">
                                    <i class="fa fa-plus-circle"></i>
                                    Tambah Tunjangan
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="tblTunjangan" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script type="text/javascript">
    var routeTblGaji = "{{ route('penggajian.listGaji') }}",
        periodeId = $('#periodeId').val(),
        karyawanId = $('#karyawanId').val();
</script>
<script type="text/javascript" src="{{ asset('assets/js/showPenggajian.js?nocache='.time()) }}"></script>
@endsection