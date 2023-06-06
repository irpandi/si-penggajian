@extends('layouts.home', [
    'title' => $data['title'],
    'breadcrumbs' => $data['breadcrumbs']
])

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
                <form action="{{ route('penggajian.store') }}" method="post">
                    @csrf
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Tambah Data Penggajian</h4>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label>Pilih Periode</label>
                                <div class="input-group mb-3">
                                    <select class="form-control" id="tglPeriode" name="tglPeriode" required>
                                        <option></option>
                                    </select>
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar-alt"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Pilih Karyawan</label>
                                <div class="input-group mb-3">
                                    <select class="form-control" id="karyawan" name="karyawan" required>
                                        <option></option>
                                    </select>
                                    <div class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Pilih Barang</label>
                                <div class="input-group mb-3">
                                    <select class="form-control" id="barang" name="barang" required>
                                        <option></option>
                                    </select>
                                    <div class="input-group-text">
                                        <i class="fa fa-cog"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Pilih Item</label>
                                <div class="input-group mb-3">
                                    <select class="form-control" id="item" name="item" required>
                                        <option></option>
                                    </select>
                                    <div class="input-group-text">
                                        <i class="fa fa-table"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Total Pengerjaan Item</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="totalPengerjaanItem" name="totalPengerjaanItem" placeholder="Input total pengerjaan item" required>
                                    <div class="input-group-text">
                                        <i class="fas fa-table"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script type="text/javascript">
    var routeOptPenggajian = "{{ route('penggajian.optPenggajian') }}";
</script>
<script type="text/javascript" src="{{ asset('assets/js/createPenggajian.js?nocache='.time()) }}"></script>
@if(session('message'))
<script type="text/javascript">
    customSweetAlert("{{ session('icon') }}", "{{ session('title') }}", "{{ session('message') }}");
</script>
@endif
@endsection