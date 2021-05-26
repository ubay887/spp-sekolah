@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header">
        <h1>Manajemen Siswa</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Siswa</a></div>
            <div class="breadcrumb-item">Create Siswa</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <a href="{{ route('siswa.index')}}" class="btn">
                            <i class="fas fa-arrow-left  text-dark  "></i>
                        </a>
                        <h4 class="ml-3">Form Tambah Siswa</h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <form method="POST" action="{{ route('siswa.store') }}" enctype="multipart/form-data">
                            @csrf
                        <div class="row">
                            {{-- <div class="col-md-1"></div> --}}
                            <div class="col-md-3 px-3">
                                <div class="form-group">
                                    <label for="foto_siswa">Foto Siswa</label>
                                    <input type="file" class="form-control logo @error('foto_siswa') is-invalid @enderror" name="foto_siswa" id="foto_siswa" value="{{ old('foto_siswa') }}" data-default-file="{{ old('foto_siswa') }}"  data-height="282">
                                    @error('foto_siswa')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.col-md -->

                            <div class="col-md-4 px-3">
                                <div class="form-group">
                                    <label for="nis">NIS</label>
                                    <input type="text" class="form-control @error('nis') is-invalid @enderror" name="nis" id="nis" value="{{ old('nis') }}"  placeholder="nis" autofocus>
                                    @error('nis')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}"  placeholder="nama_lengkap" autofocus>
                                    @error('nama_lengkap')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Jenis Kelamin</label><br>
                                    <input type="radio" id="one" value="male" name="jenis_kelamin">
                                    <label for="one">Laki-Laki</label>

                                    <input type="radio" id="two" value="female" name="jenis_kelamin" >
                                    <label for="two">Perempuan</label>
                                    @error('jenis_kelamin')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"  placeholder="tempat_lahir">
                                    @error('tempat_lahir')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"  placeholder="tanggal_lahir">
                                    @error('tanggal_lahir')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                                        <option value="">-Pilih Kelas-</option>
                                        @foreach ($kelas as $item)
                                        <option value="{{ $item->id  }}"
                                                @if ($item->id == old('kelas_id'))
                                                    selected
                                                @endif    
                                            >
                                            
                                            {{ $item->nama_kelas }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama_ibu_kandung">Nama Ibu Kandung</label>
                                    <input type="text" class="form-control @error('nama_ibu_kandung') is-invalid @enderror" name="nama_ibu_kandung" id="nama_ibu_kandung" value="{{ old('nama_ibu_kandung') }}"  placeholder="nama_ibu_kandung">
                                    @error('nama_ibu_kandung')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nama_ayah_kandung">Nama Ayah Kandung</label>
                                    <input type="text" class="form-control @error('nama_ayah_kandung') is-invalid @enderror" name="nama_ayah_kandung" id="nama_ayah_kandung" value="{{ old('nama_ayah_kandung') }}"  placeholder="nama_ayah_kandung">
                                    @error('nama_ayah_kandung')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="no_telp_orangtua">No. Telp Orangtua</label>
                                    <input type="text" class="form-control @error('no_telp_orangtua') is-invalid @enderror" name="no_telp_orangtua" id="no_telp_orangtua" value="{{ old('no_telp_orangtua') }}"  placeholder="no_telp_orangtua">
                                    @error('no_telp_orangtua')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
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
            $('#kelas_id').select2()

            $('#foto_siswa').dropify({
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
