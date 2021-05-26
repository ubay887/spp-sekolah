@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header ">
        <h1>Manajemen Kelas</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Kelas</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <h4>Laporan Pembayaran</h4>
                        <div class="card-header-action">
                            <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-icon"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Tambah Data">
                                <i class="fas fa-plus-circle px-2    "></i>
                            </a>
                            
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('laporan.pembayaran') }}" method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Dari Tanggal</label>
                                    <input type="date"
                                        class="form-control" name="start_date" value="{{ (!empty(request()->start_date)) ? request()->start_date : old('start_date') }}" id="start_date" aria-describedby="helpId" placeholder="">
                                    @error('start_date')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="end_date">Sampai Tanggal</label>
                                    <input type="date"
                                        class="form-control" name="end_date" value="{{ (!empty(request()->end_date)) ? request()->end_date : old('end_date') }}" id="end_date" aria-describedby="helpId" placeholder="">
                                        @error('end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mode">Mode</label>
                                    <select class="form-control" name="mode" id="mode" required>
                                        <option value="">Pilih</option>
                                        <option value="simple" {{ (request()->mode === 'simple') ? 'selected' : ''}}>Simple</option>
                                        <option value="detail" {{ (request()->mode === 'detail') ? 'selected' : ''}}>Detail</option>
                                    </select>
                                    @error('mode')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenisPembayaran">Jenis Pembayaran</label>
                                    <select class="form-control" name="jenisPembayaran" id="jenisPembayaran">
                                        <option value="">Pilih</option>
                                        @foreach ($jenisPembayaran as $item)
                                            <option value="{{$item->nama_pembayaran}}" {{ (request()->jenisPembayaran === $item->nama_pembayaran) ? 'selected' : ''}}>{{$item->nama_pembayaran}}</option>
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
                        @if (!empty($data))
                            <div class="div">
                                <a href="{{ route('laporan.pembayaranPdf')}}" target="blank" class="btn btn-light">
                                    <i class="fas fa-file-pdf    "></i>
                                    PDF
                                </a>
                                @if (request()->mode === 'simple')
                                    
                                <a href="{{ route('laporan.pembayaranExcel')}}" target="blank" class="btn btn-light">
                                    <i class="fas fa-file-pdf    "></i>
                                    Excel
                                </a>
                                @endif
                            </div>
                            @if (request()->mode === 'simple')
                                <div class="table-responsive">
                                    <table class="table table-head-fixed table-bordered table-stripe mt-4">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tgl.Pembayaran</th>
                                                <th>
                                                    NIS/Nama
                                                </th>
                                                <th>Nama Pembayaran</th>
                                                <th>Keterangan</th>
                                                {{-- <th>Status <br> {{ $row->status }}</th> --}}
                                                <th class="text-right">Jumlah Bayar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @foreach ($data as $row)
                                                <tr>
                                                    <td style="width: 50px">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td >
                                                        {{ date_format(date_create($row->transaksi_pembayaran->created_at), 'd-m-Y') }}
                                                    </td>
                                                    <td>
                                                        {{ @$row->transaksi_pembayaran->siswa->nis}} <br>
                                                        {{ @$row->transaksi_pembayaran->siswa->nama_lengkap}}
                                                    </td>
                                                    <td>
                                                        {{ $row->nama_pembayaran}}
                                                    </td>
                                                    <td>
                                                        {{ $row->keterangan}}
                                                    </td>
                                                    <td class="text-right">
                                                        Rp.{{ number_format($row->harga) }}
                                                    </td>
                                                </tr>                                  
                                                    
                                                @endforeach
    
                                        </tbody>
                                    </table>

                                </div>
                            @else
                                <div class="table-responsive">
                                    @foreach ($data as $row)
                                    <table class="table table-head-fixed text-nowrap table-bordered table-stripe mt-4">
                                        <thead>
                                            <tr>
                                                {{-- <th>#</th> --}}
                                                <th>{{ $loop->iteration }}</th>
                                                <th>
                                                    Tanggal Pembayaran : <br>
                                                    {{ date_format(date_create($row->created_at), 'd-m-Y') }}
                                                </th>
                                                <th>{{ @$row->siswa->nis }} -   
                                                    {{ @$row->siswa->kelas->nama_kelas }}<br>
                                                    <strong>{{ @$row->siswa->nama_lengkap }}</strong> <br></th>
                                                <th>Metode Pembayaran <br> {{ $row->metode_pembayaran }}</th>
                                                {{-- <th>Status <br> {{ $row->status }}</th> --}}
                                                <th class="text-right">Total Bayar <br> Rp.{{ number_format($row->total) }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @foreach ($row->detail_pembayaran as $item)
                                                <tr>
                                                    <td style="width: 50px"></td>
                                                    <td colspan="3">
                                                        {{ $item->nama_pembayaran }} - {{ $item->keterangan }}
                                                    </td>
                                                    {{-- <td></td> --}}
                                                    <td class="text-right">
                                                        Rp.{{ number_format($item->harga) }}
                                                    </td>
                                                </tr>                                  
                                                    
                                                @endforeach
            
                                        </tbody>
                                    </table>
                                    @endforeach
                                </div>
                            @endif

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

<!-- Modal Delete-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mt-3">Apakah kamu yakin menghapus Data Kelas ?</p>
            </div>
            <div class="modal-footer">
                <form action="" method="POST" id="deleteForm">
                    @method('DELETE')
                    @csrf
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak, Kembali</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
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

@if(session()->has('error'))
    <script>
        $(document).ready(function () {
            // toastr["info"]('{{ session()->get('error') }}')
            iziToast.info({
                title: '',
                message: '{{ session()->get('success') }}',
                position: 'bottomCenter'
            });
        });

    </script>
@endif

@endsection
