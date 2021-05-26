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
                        <h4>Kelas</h4>
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
                        
                        <form action="{{ route('kelas.index') }}" method="GET">
                            {{-- @csrf --}}
                            <div class="input-group input-group mb-3 float-right" style="width: 300px;">
                                <input type="text" name="keyword" class="form-control float-right"
                                placeholder="Search" value="{{request()->query('keyword')}}">
    
                                
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-light"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="input-group-append">
                                    <a href="{{ route('kelas.index') }}" title="Refresh" class="btn btn-light"><i class="fas fa-circle-notch mt-2    "></i></a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-head-fixed text-nowrap table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>No</th>
                                        <th>Nama Kelas</th>
                                        <th>Total Siswa</th>
                                        {{-- <th>#</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kelas as $row)
                                        <tr>
                                            <td style="width: 20px">
                                                <div class="btn-group">
                                                    <button type="button" class="btn" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v    "></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('kelas.edit', $row->id) }}">
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
                                            <td style="width: 50px">{{ $loop->iteration }}</td>
                                            <td>{{ $row->nama_kelas }}</td>
                                            <td class="text-center">{{$row->siswa->where('status','Aktif')->count() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Data Tidak Ada</td>
                                        </tr>
                                    @endforelse
    
                                </tbody>
                            </table>
                            {{ $kelas->appends(['keyword' => request()->query('keyword')])->links() }}
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <span class="text-sm float-right">Total Entries : {{$kelas->total()}}</span>
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
                message: '{{ session()->get('error') }}',
                position: 'bottomCenter'
            });
        });

    </script>
@endif

@endsection
