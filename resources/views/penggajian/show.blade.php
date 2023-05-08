@extends('layouts.home', [
    'title' => $data['title'],
    'breadcrumbs' => $data['breadcrumbs']
])

@php
    use App\Http\Service\General;
@endphp

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
                            <input type="number" class="form-control" placeholder="Jumlah Tunjangan" id="jumlahTunjangan" name="jumlahTunjangan">
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
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show errorAlert" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
    
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="hidden" id="karyawanId" value="{{ $data['karyawan']->id }}">
            <input type="hidden" id="periodeId" value="{{ $data['periode']->id }}">
            <input type="hidden" id="totalGajiId" value="{{ $data['karyawan']->totalGaji->id }}">
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
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td>{{ ucwords($data['karyawan']->jenis_kelamin) }}</td>
                                </tr>

                                <tr>
                                    <td>Tempat, Tanggal Lahir</td>
                                    <td>:</td>
                                    <td>{{ $data['karyawan']->tempat_lahir }}, {{ General::manageDate('Y-m-d', $data['karyawan']->tgl_lahir, 'd/m/Y') }}</td>
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
                                    <td>{{ General::manageDate('Y-m-d', $data['periode']->tgl_periode, 'd/m/Y') }}</td>
                                </tr>

                                <tr>
                                    <td>Total Gaji</td>
                                    <td>:</td>
                                    <td><span id="totalGaji">{{ General::formaterNumber($data['karyawan']->totalGaji->total, 0) }}</span></td>
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
        karyawanId = $('#karyawanId').val(),
        routeDestroyGaji = "{{ route('penggajian.destroy.gaji', ':id') }}",
        csrfToken = "{{ csrf_token() }}",
        routeRefreshTotalGaji = "{{ route('penggajian.refreshTotalGaji', ':id') }}",
        routeAddTunjangan = "{{ route('tunjangan.store') }}",
        routeListTunjangan = "{{ route('tunjangan.listTunjangan') }}",
        totalGajiId = $('#totalGajiId').val();
</script>
<script type="text/javascript" src="{{ asset('assets/js/showPenggajian.js?nocache='.time()) }}"></script>
@if(session('message'))
<script type="text/javascript">
    customSweetAlert("{{ session('icon') }}", "{{ session('title') }}", "{{ session('message') }}");
</script>
@endif
@endsection