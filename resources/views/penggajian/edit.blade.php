@extends('layouts.home', [
    'title' => $data['title'],
    'breadcrumbs' => $data['breadcrumbs']
])

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

            <input type="hidden" id="dataGaji" value="{{ $data['dataGaji'] }}">
            <input type="hidden" id="dataPeriode" value="{{ $data['dataGaji']->subItem->periode }}">
            <input type="hidden" id="dataKaryawan" value="{{ $data['dataGaji']->karyawan }}">
            <input type="hidden" id="dataBarang" value="{{ $data['dataGaji']->subItem->item->barang }}">
            <input type="hidden" id="dataItem" value="{{ $data['dataGaji']->subItem->item }}">
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="post">
                        @csrf
                        @method('put')
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4>Edit Data Penggajian</h4>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <select class="form-control" id="tglPeriode" name="tglPeriode" required>
                                        <option></option>
                                    </select>
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar-alt"></i>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <select class="form-control" id="karyawan" name="karyawan" required>
                                        <option></option>
                                    </select>
                                    <div class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <select class="form-control" id="barang" name="barang" required>
                                        <option></option>
                                    </select>
                                    <div class="input-group-text">
                                        <i class="fa fa-cog"></i>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <select class="form-control" id="item" name="item" required>
                                        <option></option>
                                    </select>
                                    <div class="input-group-text">
                                        <i class="fa fa-table"></i>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="totalPengerjaanItem" name="totalPengerjaanItem" value="{{ $data['dataGaji']->subItem->total_pengerjaan_item }}" placeholder="Input total pengerjaan item" required>
                                    <div class="input-group-text">
                                        <i class="fas fa-table"></i>
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
        </div>
    </section>
@endsection

@section('script')
<script type="text/javascript">
    var routeOptPenggajian = "{{ route('penggajian.optPenggajian') }}",
        gaji = $('#dataGaji').val(),
        karyawan = $('#dataKaryawan').val(),
        periode = $('#dataPeriode').val(),
        barang = $('#dataBarang').val(),
        item = $('#dataItem').val(),
        dataGaji = JSON.parse(gaji),
        dataKaryawan = JSON.parse(karyawan),
        dataPeriode = JSON.parse(periode),
        dataBarang = JSON.parse(barang),
        dataItem = JSON.parse(item);
</script>
<script type="text/javascript" src="{{ asset('assets/js/editPenggajian.js?nocache='.time()) }}"></script>
@if(session('message'))
<script type="text/javascript">
    customSweetAlert("{{ session('icon') }}", "{{ session('title') }}", "{{ session('message') }}");
</script>
@endif
@endsection