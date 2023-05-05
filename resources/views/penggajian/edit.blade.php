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
            <input type="hidden" id="dataPeriode" value="{{ $data['dataGaji']->subItem->item->barang->periode }}">
            <input type="hidden" id="dataKaryawan" value="{{ $data['dataGaji']->karyawan }}">
            <input type="hidden" id="dataBarang" value="{{ $data['dataGaji']->subItem->item->barang }}">
            <input type="hidden" id="dataItem" value="{{ $data['dataGaji']->subItem->item }}">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('penggajian.update', $data['dataGaji']->sub_item_id) }}" method="post">
                        @csrf
                        @method('put')

                        <input type="hidden" name="tglPeriode" value="{{ $data['dataGaji']->subItem->item->barang->periode_id }}">
                        <input type="hidden" name="karyawan" value="{{ $data['dataGaji']->karyawan_id }}">
                        <input type="hidden" name="barang" value="{{ $data['dataGaji']->subItem->item->barang_id }}">
                        <input type="hidden" name="item" value="{{ $data['dataGaji']->subItem->item->id }}">

                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4>Edit Data Penggajian</h4>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <select class="form-control" id="tglPeriode" required disabled>
                                        <option></option>
                                    </select>
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar-alt"></i>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <select class="form-control" id="karyawan" required disabled>
                                        <option></option>
                                    </select>
                                    <div class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <select class="form-control" id="barang" required disabled>
                                        <option></option>
                                    </select>
                                    <div class="input-group-text">
                                        <i class="fa fa-cog"></i>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <select class="form-control" id="item" required disabled>
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
                                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
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