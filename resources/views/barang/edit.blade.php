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
                <form action="{{ route('barang.update', $data['barang']->id) }}" method="post">
                    @csrf
                    @method('put')

                    <input type="hidden" name="tglPeriode" value="{{ $data['barang']->periode_id }}">
                    <input type="hidden" id="dataPeriode" value="{{ $data['barang']->periode }}">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Edit Data Barang</h4>
                            </div>
                        </div>
    
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <select class="form-control" id="tglPeriode">
                                    <option></option>
                                </select>
                                <div class="input-group-text">
                                    <i class="fa fa-calendar-alt"></i>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nama Barang" id="nama" name="nama" value="{{ $data['barang']->nama }}" required>
                                <div class="input-group-text">
                                    <i class="fas fa-table"></i>
                                </div>
                            </div>
    
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Merk Barang" id="merk" name="merk" value="{{ $data['barang']->merk }}" required>
                                <div class="input-group-text">
                                    <i class="fas fa-toolbox"></i>
                                </div>
                            </div>
    
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="Total Barang" id="total" name="total" value="{{ $data['barang']->total }}" required>
                                <div class="input-group-text">
                                    <i class="fas fa-cog"></i>
                                </div>
                            </div>

                            {{-- Form Item Pengerjaan Barang --}}
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-outline card-success">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h5>Item Pengerjaan Barang</h5>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                @if(count($data['barang']->item) > 0)
                                                    @foreach($data['barang']->item as $value)
                                                        <div id="inputFormItem">
                                                            <input type="hidden" name="itemId[]" value="{{ $value->id }}">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <div class="card-title">
                                                                        Item
                                                                    </div>

                                                                    <div class="card-tools">
                                                                        <button type="button" id="deleteItemPermanently" data-id="{{ $value->id }}" class="close" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                                <div class="card-body">
                                                                    <div class="input-group mb-3">
                                                                        <input type="text" class="form-control" placeholder="Nama Item" id="namaItem" name="namaItemUpdate[]" value="{{ $value->nama }}">
                                                                        <div class="input-group-text">
                                                                            <i class="fas fa-table"></i>
                                                                        </div>
                                                                    </div>
                
                                                                    <div class="input-group mb-3">
                                                                        <input type="number" class="form-control" placeholder="Harga Item" id="hargaItem" name="hargaItemUpdate[]" value="{{ $value->harga }}">
                                                                        <div class="input-group-text">
                                                                            <i class="fas fa-cog"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div id="inputFormItem">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <div class="card-title">
                                                                    Item
                                                                </div>

                                                                <div class="card-tools">
                                                                    <button type="button" id="deleteItem" class="close" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div class="card-body">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control" placeholder="Nama Item" id="namaItem" name="namaItem[]">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-table"></i>
                                                                    </div>
                                                                </div>
            
                                                                <div class="input-group mb-3">
                                                                    <input type="number" class="form-control" placeholder="Harga Item" id="hargaItem" name="hargaItem[]">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-cog"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div id="newItem"></div>
                                            </div>

                                            <div class="card-footer text-right">
                                                <button type="button" id="addItem" class="btn btn-sm btn-success">Tambah Item</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Form Item Pengerjaan Barang --}}
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
    var routeDestroyItem = "{{ route('barang.destroy.item', ':id') }}",
        csrfToken = "{{ csrf_token() }}",
        routeOptPenggajian = "{{ route('penggajian.optPenggajian') }}",
        dataPeriode = JSON.parse($('#dataPeriode').val());
</script>
<script type="text/javascript" src="{{ asset('assets/js/editBarang.js?nocache='.time()) }}"></script>
@if(session('message'))
<script type="text/javascript">
    customSweetAlert("{{ session('icon') }}", "{{ session('title') }}", "{{ session('message') }}");
</script>
@endif
@endsection