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
                        <h4>Settings Aplikasi</h4>
                        <div class="card-header-action">

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-secondary text-white">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4>Pengaturan Aplikasi</h4>
                                        <p>Nama Aplikasi, Footer Left, Footer Right, Favicon.
                                        </p>
                                        <a href="{{route('setting.aplikasi')}}" class="card-cta">Ubah Pengaturan <i
                                                class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-info text-white">
                                        <i class="fas fa-money-bill    "></i>
                                    </div>
                                    <div class="card-body">
                                        <h4>Pengaturan Payment Gateway</h4>
                                        <p>Status Development/Production, Client Secret Key, Server Secret Key API.</p>
                                        <a href="{{route('setting.payment')}}" class="card-cta">Ubah Pengaturan <i
                                                class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-primary text-white">
                                        <i class="fas fa-school    "></i>
                                    </div>
                                    <div class="card-body">
                                        <h4>Pengaturan Sekolah</h4>
                                        <p>Nama Sekolah, Alamat, Kota, No.telp, Email.</p>
                                        <a href="{{route('setting.sekolah')}}" class="card-cta">Ubah Pengaturan <i
                                                class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-warning text-white">
                                        <i class="fas fa-database    "></i>
                                    </div>
                                    <div class="card-body">
                                        <h4>Backup Database</h4>
                                        <p>Backup Database</p>
                                        <a href="{{route('backup.index')}}" class="card-cta">Ubah Pengaturan <i
                                                class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div> --}}
                            
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
    $(document).ready(function () {
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
