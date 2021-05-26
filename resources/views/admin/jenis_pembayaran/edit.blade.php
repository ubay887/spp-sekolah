@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header ">
        <h1>Manajemen Jenis Pembayaran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('jenispembayaran.index') }}">Jenis Pembayaran</a></div>
            <div class="breadcrumb-item">Create Jenis Pembayaran</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <a href="{{ route('jenispembayaran.index')}}" class="btn">
                            <i class="fas fa-arrow-left  text-dark  "></i>
                        </a>
                        <h4 class="ml-3">Form Edit Jenis Pembayaran</h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <form method="POST" action="{{ route('jenispembayaran.update', $jenisPembayaran->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="old_tipe" value="{{$jenisPembayaran->tipe}}">
                                    <div class="form-group">
                                        <label for="nama_pembayaran">Nama Pembayaran</label>
                                        <input type="text" name="nama_pembayaran" class="form-control @error('nama_pembayaran') is-invalid @enderror"  id="nama_pembayaran" value="{{ $jenisPembayaran->nama_pembayaran }}"  placeholder="Contoh SPP, DSP, Sumbangan apalah" autofocus>
                                        @error('nama_pembayaran')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tahunajaran_id">Tahun Pelajaran</label>
                                        <select name="tahunajaran_id" id="tahunajaran_id" class="form-control @error('tahunajaran_id') is-invalid @enderror">
                                            <option value="">-Pilih Tahun Pelajaran-</option>
                                            @foreach ($tahun_ajaran as $item)
                                            <option value="{{ $item->id  }}"
                                                    @if ($item->id == $jenisPembayaran->tahunajaran_id)
                                                        selected
                                                    @endif    
                                                >
                                                
                                                {{ $item->tahun_ajaran }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('tahunajaran_id')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tipe">Tipe Pembayaran</label>
                                        <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror">
                                            <option value="">-Pilih Tipe Pembayaran-</option>
                                            <option value="bulanan" {{ ('bulanan' === $jenisPembayaran->tipe) ? 'selected' : '' }}>Setiap Bulan</option>
                                            <option value="bebas" {{ ('bebas' === $jenisPembayaran->tipe) ? 'selected' : '' }}>Bebas/Angsuran</option>
                                        </select>
                                        @error('tipe')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="harga">Biaya/Nominal</label>
                                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"  id="harga" value="{{ $jenisPembayaran->harga }}"  placeholder="Masukkan Biaya atau jumlah Nominal" autofocus>
                                        @error('harga')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="kelas_id">Pembayaran Untuk </label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" 
                                            name="kelas_id[]" 
                                            value="semua" 
                                            class="custom-control-input" 
                                            id="one"
                                            {{(is_array(old('kelas_id')) && in_array($item->id, old('kelas_id'))) ? 'checked' : ''}}>
                                            <label class="custom-control-label" for="one">Semua Kelas</label>
                                        </div>
                                        @foreach ($kelas as $item)
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" 
                                                name="kelas_id[]" 
                                                value="{{ $item->id }}" class="custom-control-input" 
                                                id="customCheck{{$item->id}}" 
                                                @if(is_array($tempKelas) && in_array($item->id, $tempKelas))
                                                    checked
                                                @endif
                                                >
                                                <label class="custom-control-label" for="customCheck{{$item->id}}">{{$item->nama_kelas}}</label>
                                            </div>
                                        @endforeach
                                        
                                        
                                        @error('kelas_id')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-none">
                                        <label for="kelas_id">Pembayaran Untuk old </label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" 
                                            name="old_kelas_id[]" 
                                            value="semua" 
                                            class="custom-control-input" 
                                            id="one"
                                            {{(is_array(old('kelas_id')) && in_array($item->id, old('kelas_id'))) ? 'checked' : ''}}>
                                            <label class="custom-control-label" for="one">Semua Kelas</label>
                                        </div>
                                        @foreach ($kelas as $item)
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" 
                                                name="old_kelas_id[]" 
                                                value="{{ $item->id }}" class="custom-control-input" 
                                                id="customCheck{{$item->id}}" 
                                                @if(is_array($tempKelas) && in_array($item->id, $tempKelas))
                                                    checked
                                                @endif
                                                >
                                                <label class="custom-control-label" for="customCheck{{$item->id}}">{{$item->nama_kelas}}</label>
                                            </div>
                                        @endforeach
                                        
                                        
                                        @error('kelas_id')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- <hr> --}}
                                    <div class="form-group d-flex justify-content-end">
                                        <a class="btn btn-light " href="{{ route('jenispembayaran.index') }}">Batal</a>
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
    <script>
        $(document).ready(function () {
            $('#tipe').select2()
            $('#tahunajaran_id').select2()
            $("#one").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
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
