@extends('layouts.auth')

@section('content')
<section class="section">
    <div class="container p-5">
        <div class="row" style="height: 430px">
            <div class="col-md-6 col-lg-8  d-flex align-items-center">
                <img class="d-lg-block d-md-block d-sm-none d-none img-fluid "  style="opacity: 0.9"  src="img/undraw_Brainstorming_re_1lmw.png" alt="">
            </div>
            <div class="col-md-6 col-sm-12 col-lg-4  d-flex flex-column align-items-center">
                <div class="text-center d-flex align-items-center justify-content-center mb-2">
                    <img height="60px" width="60px" class="mr-3" src="{{ asset('/img/').'/'.\Setting::getSetting()->logo }}" alt="">
                    {{-- <h5>SI-SPP</h5> --}}
                    <h6>
                        {{-- SI-SPP <br> --}}
                        Sistem Informasi <br> Pembayaran Sekolah
                    </h6>
                </div>
                <div class="card card-primary w-100 shadow" >
                    <div class="card-header">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <p class="text-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif
                        {{-- @yield('content') --}}
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('username') is-invalid @enderror " placeholder="Username"
                                    name="username" value="{{ old('username') }}" required autocomplete="username" id="username"
                                    autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user-alt"></span>
                                    </div>
                                </div>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>tess</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="small mt-n2 mb-2 ml-3 text-muted">
                                Untuk Siswa Silahkan Login Menggunakan NIS.
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Password" name="password" value="{{ old('password') }}" required
                                    autocomplete="current-password" id="password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="small mt-n2 mb-2 ml-3 text-muted">
                                Password Default Siswa 123456.
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">Remember Me</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Login
                                </button>
                            </div>
                        </form>
            
                        {{-- <p class="mb-1">
                            <a href="forgot-password.html">I forgot my password</a>
                        </p> --}}
                        {{-- <div class="callout callout-info mt-3 small d-flex justify-content-between">
                            <div>
                                
                                <h6 ><a href="#" id="admin">Admin</a></h6>
                                <span><strong>Username</strong> : <br> admin</span><br>
                                <span><strong>Password</strong> : <br> password</span><br><br>
                            </div>
                            <div>
                                <h6 ><a href="#" id="siswa">Siswa</a></h6>
                                <span><strong>Username</strong> : <br> 0054088460</span><br>
                                <span><strong>Password</strong> : <br> 123456</span>
                            </div>
                        </div> --}}

                    </div>
                    <!-- /.login-card-body -->
                    <div class="simple-footer mt-n1">
                        {{\Setting::getSettingSekolah()->nama_sekolah}} <br>
                        {{\Setting::getSettingSekolah()->kota}} <br>
                        © {{date("Y")}}
                    </div>
                </div>
            </div>
            
        </div>        
    </div>
    
</section>
<!-- /.login-box -->
@endsection


@section('scripts')
<script>
    $(document).ready(function () {
        $("#admin").click(function (e) {
            e.preventDefault()
            
            $("#username").val('admin');
            $("#password").val('password');
        });

        $("#siswa").click(function (e) {
            e.preventDefault()
            
            $("#username").val('0054088460');
            $("#password").val('123456');
        });

        $("#kelas_id").change(function(){
            filter();
        });
    });

</script>

@endsection
