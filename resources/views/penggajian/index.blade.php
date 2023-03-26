@extends('layouts.home', [
    'title' => $data['title'],
    'breadcrumbs' => $data['breadcrumbs']
])

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $data['title'] }}</div>

                        <div class="card-tools">
                            <a href="#" class="btn btn-sm btn-primary">
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
                                    <th>Periode</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/js/penggajian.js') }}"></script>
@endsection