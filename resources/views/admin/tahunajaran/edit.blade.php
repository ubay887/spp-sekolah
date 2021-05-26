@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header ">
        <h1>Manajemen Tahun Pelajaran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('tahunajaran.index') }}">Tahun Pelajaran</a></div>
            <div class="breadcrumb-item">Edit Tahun Pelajaran</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <a href="{{ route('tahunajaran.index')}}" class="btn">
                            <i class="fas fa-arrow-left  text-dark  "></i>
                        </a>
                        <h4 class="ml-3">Form Edit Tahun Pelajaran</h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <form method="POST" action="{{ route('tahunajaran.update', $tahunajaran->id)}}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="tahun_ajaran">Tahun Pelajaran</label>
                                        <input type="text" name="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror"  id="tahun_ajaran" value="{{ $tahunajaran->tahun_ajaran }}"  placeholder="Contoh 2020/2021" autofocus>
                                        @error('tahun_ajaran')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- <hr> --}}
                                    <div class="form-group d-flex justify-content-end">
                                        <a class="btn btn-light " href="{{ route('tahunajaran.index') }}">Batal</a>
                                        <button type="submit" class="btn btn-primary ml-2">
                                            Simpan
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
