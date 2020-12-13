<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>News Blog - @yield('title')</title>
    @yield('prestyle')
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ url('assets/backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('assets/backend/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- custom CSS -->
    <link rel="stylesheet" href="{{ url('assets/custom.css') }}">
    {{-- para el captcha --}}
    {!! NoCaptcha::renderJs() !!}
    @yield('poststyle')

</head>

<body>

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        @auth
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('posts.index') }}" class="nav-link">Dashboard</a>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Login-Logout -->
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        @endauth
        @guest
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li> --}}
            </ul>
        @endguest
    </nav>


    <div class="container">
        <br>
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h1><a href="{{ route('frontend.index') }}">Magazine</a></h1>
                    <h3>News</h3>
                </div>
            </div>
        </div>
        @yield('content')
    </div>

    <!-- /.content-wrapper -->
    <!-- Footer -->
    <footer class="page-footer font-small blue pt-4">
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
            <a href="{{ route('posts.index') }}">Admin</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->


    <!-- REQUIRED SCRIPTS -->

    @yield('prescript')
    <!-- jQuery -->
    <script src="{{ url('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('assets/backend/dist/js/adminlte.js') }}"></script>
    @yield('postscript')

    @if (session()->get('op') == 'fallback')
        <script type="text/javascript">
            Command: toastr["info"]("You have been redirected to the main page", "Error 404 - Route not found")
        </script>
    @endif

</body>

</html>
