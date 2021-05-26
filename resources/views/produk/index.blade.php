@extends('layouts.master')



@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header ">
        <h1>Manajemen Produk</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Produk</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <h4>List Data Produk</h4>
                        <div class="card-header-action">
                            <a href="{{ route('produk.create') }}" class="btn btn-primary btn-icon"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Tambah Data Produk">
                                <i class="fas fa-plus-circle px-2    "></i>
                            </a>
                            <a href="#" class="btn btn-secondary btn-icon ml-2" onclick="handleImport()"
                                title="Import File" data-toggle="tooltip" data-placement="top"
                                data-original-title="Tambah Data Produk">
                                <i class="fas fa-file-import px-2   "></i>
                            </a>

                            <a href="{{ route('produk.pdf') }}" target="blank"
                                class="btn btn-secondary btn-icon ml-2" title="Cetak PDF" data-toggle="tooltip"
                                data-placement="top" data-original-title="Cetak PDF">
                                <i class="fas fa-file-pdf  px-2  "></i>
                            </a>

                            <a href="{{ route('produk.export') }}"
                                class="btn btn-secondary btn-icon ml-2" title="Export Excel" data-toggle="tooltip"
                                data-placement="top" data-original-title="Export Excel">
                                <i class="fas fa-file-excel  px-2  "></i>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('produk.index') }}" method="GET">
                            {{-- @csrf --}}
                            <div class="input-group input-group mb-3 float-right" style="width: 300px;">
                                <input type="text" name="keyword" class="form-control float-right" placeholder="Search"
                                    value="{{ request()->query('keyword') }}">


                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-light btn-icon"><i
                                            class="fas fa-search"></i></button>
                                </div>
                                <div class="input-group-append">
                                    <a href="{{ route('produk.index') }}" title="Refresh"
                                        class="btn btn-light btn-icon"><i class="fas fa-circle-notch mt-2  "></i></a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-head-fixed text-nowrap table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($produk as $row)
                                        <tr>
                                            <td style="width: 20px">
                                                <div class="btn-group">
                                                    <button type="button" class="btn" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v    "></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('produk.edit', $row->id) }}">
                                                                <i class="fas fa-edit    "></i>
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="handleDelete ({{ $row->id }})">
                                                                <i class="fas fa-trash    "></i>
                                                                Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td style="width: 50px" class="text-center">
                                                {{ $loop->iteration + $produk->firstItem() - 1 }}</td>
                                            <td class="text-center">
                                                <a href="{{ asset('/img/gambar').'/'.$row->gambar }}"
                                                    data-fancybox data-caption="{{ $row->nama_produk }}">
                                                    <img width="64px" height="64px" class="my-1 img-thumbnail"
                                                        src="{{ asset('/img/gambar').'/'. $row->gambar }}"
                                                        alt="">
                                                </a>
                                            </td>
                                            <td>{{ $row->nama_produk }}</td>
                                            <td>{{ $row->kategori->nama_kategori }}</td>
                                            <td class="text-center">{{ $row->stok }}</td>
                                            <td class="text-right">Rp. {{ number_format($row->harga_beli) }}</td>
                                            <td class="text-right">Rp. {{ number_format($row->harga_jual) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Data Tidak Ada</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                            {{ $produk->appends(['keyword' => request()->query('keyword')])->links() }}
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <span class="text-sm float-right">Total Entries : {{ $produk->total() }}</span>
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
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mt-3">Apakah kamu yakin menghapus Data Produk ?</p>
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

<!-- Modal Import File-->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Import Data Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('produk.import') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="import_produk">Import File</label>
                        <input type="file" class="form-control-file" name="import_produk" id="import_produk"
                            placeholder="" aria-describedby="fileHelpId" required>
                        <small id="fileHelpId" class="form-text text-muted">Tipe file : xls, xlsx</small>
                        <small id="fileHelpId" class="form-text text-muted">Pastikan file upload sesuai format. <br> <a
                                href="{{ url('template/contoh_format_import_siswa.xlsx') }}">Download
                                contoh format file xlsx <i class="fas fa-download ml-1   "></i></a></small>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function handleDelete(id) {
        let form = document.getElementById('deleteForm')
        form.action = `./produk/${id}`
        console.log(form)
        $('#deleteModal').modal('show')
    }

    function handleImport(e) {
        // e.preventDefault()
        $('#importModal').modal('show')
    }

    toastr.options = {
        "positionClass": "toast-bottom-center",
    }

</script>

@error('import_produk')
    {{-- <div class="text-danger small mt-1">{{ $message }}</div> --}}
    <script>
        $(document).ready(function () {
            // toastr["error"]('{{ $message }}')
            iziToast.error({
                title: '',
                message: '{{ $message }}',
                position: 'bottomCenter'
            });
        });

    </script>
@enderror

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
