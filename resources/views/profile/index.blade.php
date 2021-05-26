@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header ">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Profile</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="user-item">
                            <img alt="image" src="{{ asset('/img/profile.png') }}" class="img-fluid">
                            <div class="user-details">
                              <div class="user-name">{{ $user->name }}</div>
                              <div class="text-job text-muted">{{ $user->roles[0]->name }}</div>
                              <div class="user-cta">
                                {{-- <button class="btn btn-primary follow-btn" data-follow-action="alert('user1 followed');" data-unfollow-action="alert('user1 unfollowed');">Follow</button> --}}
                              </div>
                            </div>  
                          </div>
                        
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">


                            <div class="tab-pane active" id="profile">
                                <form class="form-horizontal" action="{{ route('profile.update', $user->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="name" value="{{ $user->name }}" class="form-control @error('stok') is-invalid @enderror" id="inputName" placeholder="Name">
                                            @error('name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" value="{{ $user->email }}" class="form-control @error('stok') is-invalid @enderror" id="inputEmail"
                                                placeholder="Email">
                                                @error('email')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-3 col-form-label">Ganti Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="inputName2" placeholder="Kosongkan jika tidak ingin mengganti password">
                                            @error('password')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="inputName2" placeholder="">
                                            @error('password_confirmation')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-3 col-sm-9">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>

    </section>
    <!-- /.content -->
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.dropify').dropify();
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
