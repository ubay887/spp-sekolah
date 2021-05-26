@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header">
        <h1>Manajemen Pegawai</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Pegawai</a></div>
            <div class="breadcrumb-item">Create Pegawai</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <a href="{{ route('pegawai.index')}}" class="btn">
                            <i class="fas fa-arrow-left  text-dark  "></i>
                        </a>
                        <h4 class="ml-3">Form Tambah Pegawai</h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <form method="POST" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5 px-5">
                                <div class="form-group">
                                    <label for="foto_pegawai">Foto Pegawai</label>
                                    <input type="file" class="form-control logo @error('foto_pegawai') is-invalid @enderror" name="foto_pegawai" id="foto_pegawai" value="{{ old('foto_pegawai') }}" data-default-file="{{ old('foto_pegawai') }}"  data-height="282">
                                    @error('foto_pegawai')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.col-md -->

                            <div class="col-md-5 px-3">
                                <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" id="nip" value="{{ old('nip') }}"  placeholder="nip" autofocus>
                                    @error('nip')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nama_pegawai">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" name="nama_pegawai" id="nama_pegawai" value="{{ old('nama_pegawai') }}"  placeholder="nama_pegawai" autofocus>
                                    @error('nama_pegawai')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="no_telp">No. Telp</label>
                                    <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" id="no_telp" value="{{ old('no_telp') }}"  placeholder="no_telp">
                                    @error('no_telp')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat"  data-height="100">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                          <div class="text-danger small mt-1">{{ $message }}</div>
                                      @enderror
                                  </div>
                                  <div class="form-group d-flex justify-content-end">
                                    <a class="btn btn-light " href="{{ route('pegawai.index') }}">Batal</a>
                                    <button type="submit" class="btn btn-primary ml-2">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                            <!-- /.col-md -->
                            <div class="col-md-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                

                            </div>
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
            // $('#kategori_id').select2()

            $('#foto_pegawai').dropify({
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
