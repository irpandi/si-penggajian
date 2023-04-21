@extends('layouts.home', [
    'title' => $data['title'],
    'breadcrumbs' => $data['breadcrumbs']
])

@section('modal')
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
                            <input type="text" class="form-control" placeholder="Nama Barang" id="nama" name="nama">
                            <div class="input-group-text">
                                <i class="fas fa-table"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Merk Barang" id="merk" name="merk">
                            <div class="input-group-text">
                                <i class="fas fa-toolbox"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="Total Barang" id="total" name="total">
                            <div class="input-group-text">
                                <i class="fas fa-cog"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $data['title'] }}</div>

                        <div class="card-tools">
                            <a href="{{ route('barang.create') }}" class="btn btn-sm btn-primary">
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
                                    <th>Merk</th>
                                    <th>Total</th>
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
    var routeList = "{{ route('barang.list') }}",
        routeShow = "{{ route('barang.show', ':id') }}";
</script>
<script type="text/javascript" src="{{ asset('assets/js/barang.js?nocache='.time()) }}"></script>
@if(session('message'))
<script type="text/javascript">
    customSweetAlert("{{ session('icon') }}", "{{ session('title') }}", "{{ session('message') }}");
</script>
@endif
@endsection