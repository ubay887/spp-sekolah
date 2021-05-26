@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header ">
        <h1>Manajemen Laporan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Laporan Tagihan</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <h4>Laporan Tagihan Siswa/i</h4>
                        <div class="card-header-action">
                            {{-- <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-icon"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Tambah Data">
                                <i class="fas fa-plus-circle px-2    "></i>
                            </a> --}}
                            
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('laporan.tagihan') }}" method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                                        <option value="">-Semua Kelas-</option>
                                        @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}"
                                                @if ($item->id == request()->kelas_id)
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
                            </div>
                            <div class="col-md-6">
                                
                                <div class="form-group">
                                    <label for="jenisPembayaran">Jenis Pembayaran</label>
                                    <select class="form-control" name="jenisPembayaran" id="jenisPembayaran" required>
                                        <option value="">Pilih</option>
                                        @foreach ($jenisPembayaran as $item)
                                            <option value="{{$item->id}}" {{ (request()->jenisPembayaran == $item->id) ? 'selected' : ''}}>{{$item->nama_pembayaran}}</option>
                                        @endforeach
                                    </select>
                                    @error('jenisPembayaran')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info float-right">Tampilkan</button>
                                </div>
                            </div>
                        </div>
                        </form>
                        <hr>
                        @if (!empty($jenisPembayaranTipe) && $tagihan->count() != 0)
                            <div class="div">
                                <a href="{{ route('laporan.tagihanPdf')}}" target="blank" class="btn btn-light">
                                    <i class="fas fa-file-pdf    "></i>
                                    PDF
                                </a>
                                <a href="{{ route('laporan.tagihanExcel')}}" target="blank" class="btn btn-light">
                                    <i class="fas fa-file-excel    "></i>
                                    Excel
                                </a>
                            </div>
                            <div class="mt-3">
                                <strong>Jenis Pembayaran : {{$tagihan->first()->jenis_pembayaran->nama_pembayaran}}</strong> <br>
                                <strong>Nominal : Rp. {{ number_format($tagihan->first()->jenis_pembayaran->harga)}}</strong> <br>
                                <strong>Tipe : {{ ($jenisPembayaranTipe === "bulanan") ? 'Bulanan' : 'Angsuran/Bebas'}}</strong><br>
                                <strong>{{ (request()->session()->get('nama_kelas') == "") ? "Semua Kelas" : request()->session()->get('nama_kelas')  }}</strong> <br>
                                
                                {{-- @if ($jenisPembayaranTipe === "bebas")
                                    <div class="text-right">
                                        <span>
                                            <i class="fas fa-check-circle text-success    "></i>
                                            @if ($tagihan->first()->jenis_pembayaran->lunas == 0)
                                                - 
                                            @else 
                                                {{$tagihan->first()->jenis_pembayaran->lunas}} Orang
                                            @endif
                                        </span>
                                        <span class="ml-3">
                                            <i class="fas fa-times-circle text-danger   "></i>
                                            @if ($tagihan->first()->jenis_pembayaran->belum_lunas == 0)
                                                - 
                                            @else 
                                                {{$tagihan->first()->jenis_pembayaran->belum_lunas}} Orang
                                            @endif
                                        </span>
                                    </div>
                                    
                                @endif --}}
                                
                            </div>
                            
                                <div class="table-responsive small  ">
                                    {{-- @foreach ($data as $row) --}}
                                    <table class="table table-head-fixed text-nowrap table-bordered table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nis Nama</th>
                                                @if ($jenisPembayaranTipe === 'bulanan')
                                                    @foreach ($bulan as $item)
                                                    <th>{{$item}}</th>
                                                    @endforeach
                                                @else
                                                <th class="text-center">Total Bayar</th> 
                                                <th class="text-center">Sisa</th> 
                                                <th>
                                                    Status
                                                </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tagihan as $row)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{@$row->siswa->nis}} -
                                                        {{@$row->siswa->kelas->nama_kelas}} <br>
                                                        {{@$row->siswa->nama_lengkap}}
                                                    </td>
                                                    @if ($jenisPembayaranTipe !== 'bulanan')
                                                        <td class="text-right">{{ number_format($row->tagihan_detail[0]->total_bayar) }}</td>
                                                        <td class="text-right">
                                                            @if ($row->tagihan_detail[0]->sisa == 0)
                                                                -
                                                            @else 
                                                                {{ number_format($row->tagihan_detail[0]->sisa) }}

                                                            @endif
                                                        </td>
                                                    @endif
                                                    
                                                    
                                                    @foreach ($row->tagihan_detail as $item)
                                                        <td style="width: 30px" class="text-center">
                                                            @if ($item->status === 'Lunas')
                                                            <i class="fas fa-check-circle text-success   " title="{{$item->status}}"></i>
                                                            @endif
                                                            @if ($item->status === 'Belum Lunas')
                                                                <i class="fas fa-times-circle text-danger   "></i>
                                                            @endif
                                                        </td>
                                                    @endforeach

                                                </tr>
                                            @endforeach 
            
                                        </tbody>
                                    </table>
                                    {{-- @endforeach --}}
                                </div>
                            
                        @else 
                        <div class="text-center mt-4">
                            @if (request()->jenisPembayaran)
                                <strong>Data Tidak Ditemukan!!</strong>
                            @endif
                        </div>
                        @endif    
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        
                    </div>
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
    function handleDelete(id) {
        let form = document.getElementById('deleteForm')
        form.action = `./kelas/${id}`
        console.log(form)
        $('#deleteModal').modal('show')
    }

</script>

@endsection
