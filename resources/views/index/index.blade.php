@extends('layouts.home', [
    'title' => $data['title'], 
    'breadcrumbs' => $data['breadcrumbs']
])

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Hello User, Selamat Datang di Aplikasi Penggajian</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
