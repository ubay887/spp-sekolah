<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='icon' href='{{ asset('/img/'.\Setting::getSetting()->favicon) }}'
        type='image/x-icon' />

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/dropify.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/jquery.fancybox.min.css') }}">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="../node_modules/bootstrap-social/bootstrap-social.css"> --}}
    <link rel="stylesheet" href="{{ asset('/themes/stisla/assets/css/select2.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('/themes/stisla/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/themes/stisla/assets/css/components.css') }}">

    
    <style>
        .iseng-sticky {
          /* position: -webkit-sticky; */
          position: sticky;
          top: 0;
          z-index: 2;
        }

        .pembayaranDetail {
          /* position: -webkit-sticky; */
          position: sticky;
          top: 100px;
          z-index: 1;
        }
        [v-cloak] { display: none; }

        .modal-mask {
            position: fixed;
            z-index: 1040;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background-color: rgba(0, 0, 0, .5); */
            display: table;
            transition: opacity .3s ease;
        }

        /* #pembayaranModal{
            z-index: 9998 !important;
        } */
        .modal-backdrop{
            /* display: none; */
            z-index: 1000 !important;
        }
        .modal-wrapper {
            display: table-cell;
            vertical-align: middle;
        }
    </style>
    @yield('css')

</head>

<body class="">
    <!-- Site wrapper -->

    <div id="iseng">
        <div class="main-wrapper">
            <div class="navbar-bg bg-info"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                        {{-- <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                    class="fas fa-search"></i></a></li> --}}
                    </ul>
                    {{-- <div class="search-element">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                            data-width="250" style="width: 250px;">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        
                    </div> --}}
                </form>
                <ul class="navbar-nav navbar-right">
                    
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img width="30" height="30" alt="image" src="{{ asset('/img/').'/'.Auth::user()->foto }}" class="rounded-circle mr-1 shadow">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }} </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">{{ ucfirst(Auth::user()->roles[0]->name) }}</div>
                            @role('admin')
                            <a href="{{route('profile.show', Auth::user()->id )}}" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            @endrole
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item has-icon text-danger"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar" tabindex="1" style="overflow: hidden; outline: none;">
                @role('siswa')
                    @include('layouts.partials.userSideBarMenu')
                @else
                    @include('layouts.partials.adminSideBarMenu')
                @endrole
            </div>


            <!-- Main Content -->
            <div class="main-content" style="min-height: 549px;">
                @yield('content')
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    {{\Setting::getSetting()->footer_left}}
                </div>
                <div class="footer-right">
                    {{\Setting::getSetting()->footer_right}}
                </div>
            </footer>
        </div>
    </div>
    
    <!-- js -->
    {{-- <script src="{{ asset('/js/app.js') }}"></script> --}}
    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('themes/stisla/assets/js/stisla.js') }}"></script>

    <script src="{{ asset('themes/stisla/assets/js/select2.full.min.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="{{ asset('themes/stisla/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('themes/stisla/assets/js/custom.js') }}"></script>

    <script src="{{ asset('/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('/js/toastr.min.js') }}"></script>
    <script src="{{ asset('/js/dropify.js') }}"></script>
    <script src="{{ asset('/js/jquery.fancybox.min.js') }}"></script>
    @yield('scripts')
    <script>
        if($("#top-4-scroll").length) {
            $("#top-4-scroll").css({
            height: 315
            }).niceScroll();
        }
    </script>
</body>

</html>
