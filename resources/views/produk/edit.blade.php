@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header">
        <h1>Manajemen Produk</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('produk.index') }}">Produk</a></div>
            <div class="breadcrumb-item">Edit Produk</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <a href="{{ route('produk.index')}}" class="btn">
                            <i class="fas fa-arrow-left  text-dark  "></i>
                        </a>
                        <h4 class="ml-3">Form Edit Produk</h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <form method="POST" action="{{ route('produk.update', $produk->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-5 px-5">
                                    <div class="form-group">
                                        <label for="gambar">Gambar Produk</label>
                                        <input type="file" class="form-control logo @error('gambar') is-invalid @enderror" name="gambar" id="gambar" value="{{ old('gambar') }}" data-default-file="{{ asset('/img/gambar/'.$produk->gambar) }}"  data-height="282">
                                        @error('gambar')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.col-md -->

                                <div class="col-md-5 px-3">
                                    <div class="form-group">
                                        <label for="nama_produk">Nama Produk</label>
                                        <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" name="nama_produk" id="nama_produk" value="{{ $produk->nama_produk }}"  placeholder="nama_produk" autofocus>
                                        @error('nama_produk')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="kategori_id">Kategori</label>
                                        <select name="kategori_id" id="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                                            <option value="">-Pilih kategori-</option>
                                            @foreach ($kategori as $item)
                                            <option value="{{ $item->id  }}"
                                                    @if ($item->id == $produk->kategori_id)
                                                        selected
                                                    @endif    
                                                >
                                                
                                                {{ $item->nama_kategori }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('kategori_id')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="harga_beli">Harga_beli</label>
                                        <input type="text" class="form-control @error('harga_beli') is-invalid @enderror" name="harga_beli" id="harga_beli" value="{{ $produk->harga_beli }}"  placeholder="harga_beli">
                                        @error('harga_beli')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="harga_jual">Harga Jual</label>
                                        <input type="text" class="form-control @error('harga_jual') is-invalid @enderror" name="harga_jual" id="harga_jual" value="{{ $produk->harga_jual }}"  placeholder="harga_jual">
                                        @error('harga_jual')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="stok">Stok</label>
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" id="stok" value="{{ $produk->stok }}"  placeholder="stok">
                                        @error('stok')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi">Produk Deskripsi</label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" data-height="100">{{ $produk->deskripsi }}</textarea>
                                        @error('deskripsi')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex justify-content-end">
                                        <a class="btn btn-light " href="{{ route('produk.index') }}">Batal</a>
                                        <button type="submit" class="btn btn-primary ml-2">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                                <!-- /.col-md -->
                                <div class="col-md-1"></div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                    {{-- <div class="card-footer clearfix">
                        tes
                    </div> --}}
                </div>
                <!-- /.card -->
            </div>
        </div>

    </section>
    <!-- /.content -->
</section>
@endsection

@section('scripts')
<script>
    
        $(document).ready(function () {
            $('#kategori_id').select2()

            $('.logo').dropify({
                messages: {
                    'default': '',
                    'replace': 'Drag and drop or click to replace',
                    'remove':  'Remove',
                    'error':   'Ooops, something wrong happended.'
                }
            });

        });

</script>



@endsection
