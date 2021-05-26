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
                        <h4>Setting Aplikasi</h4>
                        <div class="card-header-action">
                            
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('setting.update', 1) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="app_name">Nama Aplikasi</label>
                                                <input type="text" class="form-control @error('app_name') is-invalid @enderror" name="app_name" id="app_name" value="{{ $setting->app_name }}"  placeholder="Masukkan Nama kategori" autofocus>
                                                @error('app_name')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
        
                                            <div class="form-group">
                                                <label for="footer_left">Footer Kiri</label>
                                                <input type="text" class="form-control @error('footer_left') is-invalid @enderror" name="footer_left" id="footer_left" value="{{ $setting->footer_left }}"  placeholder="Masukkan Nama kategori" autofocus>
                                                @error('footer_left')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
        
                                            <div class="form-group">
                                                <label for="footer_right">Footer Kanan</label>
                                                <input type="text" class="form-control @error('footer_right') is-invalid @enderror" name="footer_right" id="footer_right" value="{{ $setting->footer_right }}"  placeholder="Masukkan Nama kategori" autofocus>
                                                @error('footer_right')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- /.col-md -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="logo">Logo</label>
                                                <input type="file" class="form-control logo @error('logo') is-invalid @enderror" name="logo" id="logo" value="{{ old('logo') }}"  data-height="100" data-width="160" data-default-file="{{ asset('/img/'.$setting->logo) }}">
                                                @error('logo')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
        
                                            <div class="form-group">
                                                <label for="favicon">favicon</label>
                                                <input type="file" class="form-control favicon @error('favicon') is-invalid @enderror" name="favicon" id="favicon" value="{{ old('favicon') }}"  data-height="100" data-width="160" data-default-file="{{ asset('/img/'.$setting->favicon) }}">
                                                @error('favicon')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
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
