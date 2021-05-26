@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header ">
        <h1>Manajemen Users</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Users</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <h4>List Data Users</h4>
                        <div class="card-header-action">
                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-icon"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Tambah Data User">
                                <i class="fas fa-plus-circle px-2    "></i>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <form action="{{ route('users.index') }}" method="GET">
                            {{-- @csrf --}}
                            <div class="input-group input-group mb-3 float-right" style="width: 250px;">
                                <input type="text" name="keyword" class="form-control float-right"
                                placeholder="Search" value="{{request()->query('keyword')}}">
    
                                
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-light"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="input-group-append">
                                    <a href="{{ route('users.index') }}" title="Refresh" class="btn btn-light"><i class="fas fa-circle-notch mt-2   "></i></a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-head-fixed text-nowrap  table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 20px">#</th>
                                        <th style="width: 50px">No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Role</th>
                                        {{-- <th>#</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $row)
                                    <tr>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn px-1" data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v    "></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('users.edit', $row->id) }}">
                                                            <i class="fas fa-edit    "></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="handleDelete ({{$row->id}})" >
                                                            <i class="fas fa-trash"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            {{ $loop->iteration + $users->firstItem() - 1 }}
                                        </td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->username}}</td>
                                        <td>{{$row->email}}</td>
                                        <td class="text-center">
                                            @if ($row->status == 1)
                                                <div class="badge badge-success">Aktif</div>
                                            @else 
                                                <div class="badge badge-warning">Non Aktif</div>
                                            @endif
                                        </td>
                                        <td class="text-center"><span class="tag tag-success">{{$row->roles->first()->name}}</span></td>
                                        
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Data Tidak Ada</td>
                                        </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                            {{ $users->appends(['keyword' => request()->query('keyword')])->links() }}
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <span class="text-sm float-right">Total Entries : {{$users->total()}}</span>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

    </section>
    <!-- /.content -->
</section>

<!-- Modal Delete-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Hapus Data Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <p class="mt-3">Apakah kamu yakin menghapus Data Users ini  ?</p>
            <p><strong>Mendelete / menghapus user bisa menyebabkan Error, disarankan untuk tidak menghapus user.</strong></p>
            <p><strong> Sebaiknya rubah status user menjadi Non Aktif jika tidak digunakan lagi.</strong></p>
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
        function handleDelete(id){
            let form = document.getElementById('deleteForm')
            form.action = `./users/${id}`
            console.log(form)
            $('#deleteModal').modal('show')
        }  
    </script>

    @if (session()->has('success'))
    <script>
        $(document).ready(function() {
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
