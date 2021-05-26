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
                        <a href="{{ route('setting.index') }}" class="btn">
                            <i class="fas fa-arrow-left  text-dark  "></i>
                        </a>
                        <h4>Pengaturan Payment Gateway Midtrans</h4>
                        <div class="card-header-action">
                            
                            
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST"
                                    action="{{ route('setting.updatePayment', 1) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="client_key_sandbox">Client Key Sandbox</label>
                                                <a class="" href="#" onclick="handleModal ()">
                                                    <i class="fas fa-question-circle    "></i>
                                                </a>
                                                <input type="text"
                                                    class="form-control @error('client_key_sandbox') is-invalid @enderror"
                                                    name="client_key_sandbox" id="client_key_sandbox"
                                                    value="{{ (!empty($setting->client_key_sandbox)) ? $setting->client_key_sandbox : ''  }}"
                                                    placeholder="Masukkan Nama kategori" autofocus>
                                                @error('client_key_sandbox')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="server_key_sandbox">Server Key Sandbox</label>
                                                <input type="text"
                                                    class="form-control @error('server_key_sandbox') is-invalid @enderror"
                                                    name="server_key_sandbox" id="server_key_sandbox"
                                                    value="{{ (!empty($setting->server_key_sandbox)) ? $setting->server_key_sandbox : '' }}"
                                                    placeholder="Masukkan Nama kategori" autofocus>
                                                @error('server_key_sandbox')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="environment">Environment</label>
                                                <select class="form-control" name="environment" id="environment">
                                                    <option value="sandbox"
                                                        {{ (!empty($setting->environment) === "sandbox") ? 'selected' : '' }}>
                                                        Sandbox</option>
                                                    <option value="production"
                                                        {{ (!empty($setting->environment) === "production") ? 'selected' : '' }}>
                                                        Production</option>
                                                </select>
                                                <small id="emailHelp" class="form-text text-muted">Untuk tes/ujicoba
                                                    aplikasi, gunakan environment Sandbox. </small>
                                            </div>
                                        </div>
                                        <!-- /.col-md -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="client_key_production" class="text-danger">Client Key
                                                    Production</label>
                                                    <a class="" href="#" onclick="handleModalProd ()">
                                                        <i class="fas fa-question-circle    "></i>
                                                    </a>
                                                <input type="text"
                                                    class="form-control @error('client_key_production') is-invalid @enderror"
                                                    name="client_key_production" id="client_key_production"
                                                    value="{{ (!empty($setting->client_key_production)) ? $setting->client_key_production : '' }}"
                                                    placeholder="Masukkan Nama kategori" autofocus>
                                                @error('client_key_production')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="server_key_production" class="text-danger">Server Key Production</label>
                                                <input type="text"
                                                    class="form-control @error('server_key_production') is-invalid @enderror"
                                                    name="server_key_production" id="server_key_production"
                                                    value="{{ (!empty($setting->server_key_production)) ? $setting->server_key_production : '' }}"
                                                    placeholder="Masukkan Nama kategori" autofocus>
                                                @error('server_key_production')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            {{-- <div class="form-group">
                                                <label for="logo">Logo</label>
                                                <input type="file" class="form-control logo @error('logo') is-invalid @enderror" name="logo" id="logo" value="{{ old('logo') }}"
                                            data-height="100" data-width="160"
                                            data-default-file="{{ asset('/img/'.$setting->logo) }}">
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

<div class="modal fade" tabindex="-1" role="dialog" id="modalSandbox" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cara Mendapatkan Client Dan Server Key Sandbox Environment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">×</span> </button>
            </div>
            <div class="modal-body"> 
                <ol>
                    <li>Buka Dashboard Midtrans.</li>
                    <li>Ubah Pilihan Environment di pojok kiri atas pada halaman dashboard Midtrans menjadi <strong>Sandbox</strong>.</li>
                    <li>Kemudian Pilih Menu <strong>Settings > Access Keys</strong>.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
{{-- modal info --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modalProd" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cara Mendapatkan Client Dan Server Key Production Environment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">×</span> </button>
            </div>
            <div class="modal-body"> 
                <ol>
                    <li>Buka Dashboard Midtrans.</li>
                    <li>Ubah Pilihan Environment di pojok kiri atas pada halaman dashboard Midtrans menjadi <strong>Production</strong>.</li>
                    <li>Kemudian Pilih Menu <strong>Settings > Access Keys</strong>.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function handleModal() {
        $('#modalSandbox').modal('show')
    }
    function handleModalProd() {
        $('#modalProd').modal('show')
    }
</script>
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
