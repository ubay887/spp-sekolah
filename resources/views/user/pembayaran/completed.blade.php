@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header">
        <h1>Transaksi Pembayaran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Transaksi Pembayaran</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        {{-- <a href="{{ route('u.siswa.show', $siswa->user_id)}}" class="btn">
                            <i class="fas fa-arrow-left  text-dark  "></i>
                        </a>
                        <h4 class="ml-3">Form Edit Siswa</h4> --}}
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <div class="text-center">
                            @if (request()->status_code === "407")
                            <h2 class="text-danger">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                             </h2>
                             <h5>
                                 Transaksi Gagal
                             </h5>
                             <p>
                                Kode : {{$transaksi->kode_pembayaran}} <br>
                                Status : {{request()->transaction_status}} <br>
                                Metode Pembayaran : {{$transaksi->metode_pembayaran}}
                            </p>
                            @endif
                            @if (request()->status_code === "201" || request()->status_code === "200" )
                            <h2 class="text-success">
                               <i class="fa fa-check-circle" aria-hidden="true"></i>
                            </h2>
                            <h5>
                                Transaksi Berhasil
                            </h5>
                            <p>
                                Kode : {{$transaksi->kode_pembayaran}} <br>
                                Status : {{request()->transaction_status}} <br>
                                Metode Pembayaran : {{$transaksi->metode_pembayaran}}
                            </p>
                            
                            <p>Detail Transaksi Dapat Dilihat <a class="" target="blank" href="{{ route('u.pembayaran.show', $transaksi->id) }}">
                                Disini
                            </a></p>
                            @endif
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
