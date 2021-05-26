@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header ">
        <h1>Settings</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Settings</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <a href="{{ route('setting.index')}}" class="btn">
                            <i class="fas fa-arrow-left  text-dark  "></i>
                        </a>
                        <h4>Pengaturan Sekolah</h4>
                        <div class="card-header-action">
                            
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('setting.updateSekolah', 1) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_sekolah">Nama Sekolah</label>
                                                <input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" name="nama_sekolah" id="nama_sekolah" value="{{ (!empty($setting->nama_sekolah)) ? $setting->nama_sekolah : '' }}"  placeholder="Masukkan Nama kategori" autofocus>
                                                @error('nama_sekolah')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
        
                                            <div class="form-group">
                                                <label for="kota">Kota</label>
                                                <input type="text" class="form-control @error('kota') is-invalid @enderror" name="kota" id="kota" value="{{ (!empty($setting->kota)) ? $setting->kota : '' }}"  placeholder="Masukkan Nama kategori" autofocus>
                                                @error('kota')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
        
                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" value="{{ (!empty($setting->alamat)) ? $setting->alamat : '' }}"  placeholder="Masukkan Nama kategori" autofocus>
                                                @error('alamat')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- /.col-md -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="no_telp">No. Telpon</label>
                                                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" id="no_telp" value="{{ (!empty($setting->no_telp)) ? $setting->no_telp : '' }}"  placeholder="No telpon Sekolah" autofocus>
                                                @error('no_telp')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ (!empty($setting->email)) ? $setting->email : '' }}"  placeholder="Email Sekolah" autofocus>
                                                @error('email')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="website">Website</label>
                                                <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" id="website" value="{{ (!empty($setting->website)) ? $setting->website : '' }}"  placeholder="Website Resmi Sekolah" autofocus>
                                                @error('website')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            {{-- <div class="form-group">
                                                <label for="logo">Logo</label>
                                                <input type="file" class="form-control logo @error('logo') is-invalid @enderror" name="logo" id="logo" value="{{ old('logo') }}"  data-height="100" data-width="160" data-default-file="{{ asset('/img/'.$setting->logo) }}">
                                                @error('logo')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div> --}}
        
                                        </div>
                                        <!-- /.col-md -->
                                    </div>
                                    <!-- /.row -->
                                    

                                    

                                    <hr>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-right">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
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

    $(document).ready(function() {
        $('.dropify').dropify();
        $('.logo').dropify();
        $('.favicon').dropify();
    });

</script>
@if(session()->has('success'))
    <script>
        $(document).ready(function () {
            // toastr["success"]('{{ session()->get('success') }}')
            iziToast.success({
                title: '',
                message: '{{ session()->get('success') }}',
                position: 'bottomCenter'
            });
        });

    </script>
@endif
@endsection
