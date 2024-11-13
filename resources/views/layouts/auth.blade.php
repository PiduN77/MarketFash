<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')
<body>
    <div id="app">
        <div class="container position-sticky z-index-sticky top-0">
            <div class="row">
                <div class="col-12">
                    <!-- Navbar -->
                    <nav
                        class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                        <div class="container-fluid pe-0">
                            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="{{ route('index') }}">
                                Marketplace
                            </a>
                            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon mt-2">
                                    <span class="navbar-toggler-bar bar1"></span>
                                    <span class="navbar-toggler-bar bar2"></span>
                                    <span class="navbar-toggler-bar bar3"></span>
                                </span>
                            </button>
                            <div class="collapse navbar-collapse" id="navigation">
                                <ul class="navbar-nav mx-auto ms-xl-auto me-xl-7">
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center me-2 active" aria-current="page"
                                            href="dashboard.html">
                                            <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                                            Dashboard
                                        </a>
                                    </li>
                                    @guest
                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="nav-link me-2" href="{{ route('register') }}">
                                                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                                    {{ __('Register') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (Route::has('login'))
                                            <li class="nav-item">
                                                <a class="nav-link me-2" href="{{ route('login') }}">
                                                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                                                    {{ __('Login') }}
                                                </a>
                                            </li>
                                        @endif
                                        @else
                                        <li class="nav-item">
                                            <a class="nav-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>
            
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <!-- End Navbar -->
                </div>
            </div>
        </div>

        <main class="main-content mt-0">
            @yield('content')
        </main>
        <footer class="footer py-5">
            <div class="container">
                <div class="row">
                    <div class="col-8 mx-auto text-center mt-1">
                        <p class="mb-0 text-secondary">
                            Copyright © 2024 by SMKN 11 TIM.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    @include('layouts.footer')
</body>

</html>
