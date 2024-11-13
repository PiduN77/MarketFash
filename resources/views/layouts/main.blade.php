<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body class="g-sidenav-show  bg-gray-100">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.navbar')

        <!-- End Navbar -->
        @yield('content')
        <footer class="footer pt-3" style="background: black;height: 50px;">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-end text-sm text-white text-lg-end">
                            © 2024, made with <i class="fa fa-heart"></i> by
                            <a href="https://smkn11bdg.sch.id/" class="font-weight-bold text-white">SMKN 11
                                TIM</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </main>
    @include('layouts.footer')
</body>

</html>
