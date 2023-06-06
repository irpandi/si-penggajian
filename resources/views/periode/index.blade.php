@extends('layouts.home', [
    'title' => $data['title'],
    'breadcrumbs' => $data['breadcrumbs']
])

@section('modal')
    {{-- Modal Template --}}
    <div class="modal fade modal-template">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleModal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="formPeriodeTemplate">
                        @csrf
                        <input type="hidden" name="_method" id="method">
                        <div class="form-group">
                            <label>Tanggal Periode</label>
                            <div class="input-group date" id="periodeDate" data-target-input="nearest">
                                <input type="text" name="tglPeriode" class="form-control datetimepicker-input" placeholder="Pilih tanggal" id="inputPeriodeDate" data-target="#periodeDate" data-toggle="datetimepicker">
                                <div class="input-group-append" data-target="#periodeDate" data-toggle="datetimepicker">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-sm btn-primary" id="periodeSave">Simpan</button>
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
                            <button type="button" class="btn btn-sm btn-primary" id="btnTambahPeriode" data-target=".modal-template" data-toggle="modal">
                                <i class="fa fa-plus-circle"></i> 
                                Tambah
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <table id="index" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Periode</th>
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
    var routeList = "{{ route('periode.list') }}",
        routeAdd = "{{ route('periode.store') }}",
        routeUpdate = "{{ route('periode.update', ':id') }}",
        routeView = "{{ route('periode.view', ':id') }}";
</script>
<script type="text/javascript" src="{{ asset('assets/js/periode.js?nocache='.time()) }}"></script>
@if(session('status'))
<script type="text/javascript">
    customSweetAlert('success', 'Sukses', "{{ session('status') }}");
</script>
@endif
@endsection