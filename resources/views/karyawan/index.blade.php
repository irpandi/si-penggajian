@extends('layouts.home', [
    'title' => $data['title'],
    'breadcrumbs' => $data['breadcrumbs']
])

@section("modal")
    {{-- Modal Template --}}
    <div class="modal fade modalTemplate">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleModal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="formTemplate">
                        @csrf
                        <input type="hidden" name="_method" id="method">

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="NIK" id="nik" name="nik">
                            <div class="input-group-text">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Nama Karyawan" id="nameKaryawan" name="nameKaryawan">
                            <div class="input-group-text">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Tempat Lahir" id="tmptLahir" name="tmptLahir">
                            <div class="input-group-text">
                                <i class="fas fa-table"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Tanggal Lahir" id="tglLahir" data-target="tglLahir" data-toggle="datetimepicker" name="tglLahir">
                            <div class="input-group-text" data-target="#tglLahir" data-toggle="datetimepicker">
                                <i class="fa fa-calendar-alt"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <select class="form-control select2Default select2Css" id="status" name="status">
                                <option value="1">Aktif</option>
                                <option value="0">Non Aktif</option>
                            </select>
                            <div class="input-group-text">
                                <i class="fas fa-table"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <select class="form-control select2Default select2Css" id="jenisKelamin" name="jenisKelamin">
                                <option value="pria">Pria</option>
                                <option value="wanita">Wanita</option>
                            </select>
                            <div class="input-group-text">
                                <i class="fas fa-table"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Nomor Handphone" id="noHp" name="noHp">
                            <div class="input-group-text">
                                <i class="fas fa-address-book"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <textarea type="text" class="form-control" placeholder="Alamat" name="alamat" id="alamat"></textarea>
                        </div>
                    </form>
                </div>

                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-sm btn-primary" id="btnSave">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="content">
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

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $data['title'] }}</div>

                        <div class="card-tools">
                            <a href="#" class="btn btn-sm btn-primary" id="btnTambah" data-target=".modalTemplate" data-toggle="modal">
                                <i class="fa fa-plus-circle"></i> 
                                Tambah
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <table id="index" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script type="text/javascript">
    var routeList = "{{ route('karyawan.list') }}",
        routeAdd = "{{ route('karyawan.store') }}",
        routeView = "{{ route('karyawan.view', ':id') }}",
        routeUpdate = "{{ route('karyawan.update', ':id') }}",
        routeDestroy = "{{ route('karyawan.destroy', ':id') }}",
        csrfToken = "{{ csrf_token() }}",
        routeStatusKaryawan = "{{ route('karyawan.statusKaryawan', ':id') }}";
</script>
<script type="text/javascript" src="{{ asset('assets/js/karyawan.js?nocache='.time()) }}"></script>
@if(session('status'))
<script type="text/javascript">
    customSweetAlert('success', 'Sukses', "{{ session('status') }}");
</script>
@endif
@endsection