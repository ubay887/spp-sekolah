@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header ">
        <h1>Manajemen Pembayaran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Detail Pembayaran</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <a href="{{ route('pembayaran.index') }}" class="btn">
                            <i class="fas fa-arrow-left  text-dark  "></i>
                        </a>
                        <h4 class="ml-3">Detail Pembayaran</h4>
                        <div class="card-header-action">
                            <a href="{{ route('pembayaran.cetak', $detail->id) }}" target="blank" class="btn btn-secondary btn-icon"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Print">
                                <i class="fas fa-print    "></i>
                            </a>
                            
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="text-left">
                                    <strong>Status</strong><br>
                                    @if ($detail->status === "cancel")
                                        <span class="text-secondary">
                                            <i class="fas fa-info-circle    "></i>
                                            Cancel
                                        </span>
                                        <br>
                                        <br>
                                        <span>
                                            Cancel at : <br>
                                            {{$detail->updated_at}}
                                        </span>
                                    @endif
                                    @if ($detail->status === "expire")
                                        <span class="text-danger">
                                            <i class="fas fa-times-circle    "></i>
                                            Expire
                                        </span>
                                        <br>
                                        <br>
                                        <span>
                                            Expire at : <br>
                                            {{$detail->updated_at}}
                                        </span>
                                    @endif
                                    @if ($detail->status === "settlement" || $detail->status === "Success")
                                        <span class="text-success">
                                            <i class="fas fa-check-circle    "></i>
                                            Paid
                                        </span>
                                        <br>
                                        <br>
                                        <span>
                                            Settlement at : <br>
                                            {{$detail->updated_at}}
                                        </span>
                                        <br>
                                        <br>
                                        <span>
                                            @if ($detail->metode_pembayaran === "Loket")
                                            <strong>Penerima :</strong> <br>
                                            {{$detail->user->name}}
                                                
                                            @endif
                                        </span>
                                    @endif
                                    @if ($detail->status === "pending")
                                        <span class="text-warning">
                                            <i class="fas fa-info-circle    "></i>
                                            Pending
                                        </span>
                                        <br>
                                        <br>
                                        <span>
                                            Segera Lakukan Pembayaran Sebelum : <br>
                                            {{$detail->due_date}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 mx-auto ">
                                {{-- <div class="h4 text-center">Pembayaran</div> --}}
                                <div class="d-flex justify-content-between">
                                    <address>
                                        <strong>Data Siswa/i:</strong><br>
                                        {{ $detail->siswa->nis }}<br>
                                        {{ $detail->siswa->nama_lengkap }}<br>
                                        {{ $detail->siswa->kelas->nama_kelas }}<br>
                                    </address>
                                    <address class="text-right">
                                        <strong>Tanggal Pembayaran:</strong><br>
                                        {{$detail->created_at}}<br>
                                        <strong>Metode Pembayaran:</strong><br>
                                        {{$detail->metode_pembayaran}}<br>
                                        {{$detail->pembayaran_detail}}<br>
                                    </address>
                                </div>

                                <div class="section-title">Detail Pembayaran</div>
                                <div>
                                    @foreach ($detail->detail_pembayaran as $item)
                                        <div class="d-flex justify-content-between border-bottom py-2">
                                            <div>
                                                <span><strong>{{ $item->nama_pembayaran}}</strong></span><br>
                                                <span class="small">{{ $item->keterangan}}</span>
                                            </div>
                                            <div>
                                                <span>Rp.{{ number_format($item->harga) }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="mt-4 text-right">
                                        <span class="">Total</span>
                                        <h5>Rp.{{ number_format($detail->total) }}</h5>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

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
