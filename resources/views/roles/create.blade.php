@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header">
        <h1>Manajemen Roles</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></div>
            <div class="breadcrumb-item">Create Role</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <a href="{{ route('roles.index')}}" class="btn">
                            <i class="fas fa-arrow-left  text-dark  "></i>
                        </a>
                        <h4 class="ml-3">Form Tambah Role</h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <form method="POST" action="{{ route('roles.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="role">Role role</label>
                                        <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" role="role" id="role" value="{{ old('role') }}"  placeholder="Masukkan Nama Role" autofocus>
                                        @error('role')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Permission</label><br>
                                        <div class="form-check">
                                            @foreach ($permissions as $item)
                                                <input class="form-check-input" 
                                                type="checkbox" 
                                                name="permissions[]" 
                                                value="{{$item->name}}" 
                                                id="{{$item->id}}"
                                                @if(is_array(old('permissions')) && in_array($item->name, old('permissions')))
                                                    checked
                                                @endif
                                                >
                                                <label class="form-check-label" for="{{$item->id}}">{{ $item->name }}</label><br>
                                            @endforeach
                                            {{ old('permissions[1]') }}
                                        </div>
                                    </div>
                                    {{-- <hr> --}}
                                    <div class="form-group d-flex justify-content-end">
                                        <a class="btn btn-light " href="{{ route('roles.index') }}">Batal</a>
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
