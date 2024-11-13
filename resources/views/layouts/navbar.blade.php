<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb" class="d-none d-sm-block d-sm-none d-md-block ">
            <a href="{{ route('index') }}">
                <h6 class="font-weight-bolder mb-0">MarketFash</h6>
            </a>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 " id="navbar">
            <div class="d-none d-sm-block d-sm-none d-md-block ms-md-auto pe-md-3 d-flex align-items-center w-50">
                <div class="input-group">
                    <span class="input-group-text text-body">
                        <a href="pencarian.html">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </a>
                    </span>
                    <input type="text" class="form-control" placeholder="Type here...">
                </div>
            </div>
            <div class="d-block d-sm-none ms-sm-auto pe-sm-3 d-flex align-items-start w-100 ">
                <div class="input-group">
                    <span class="input-group-text text-body">
                        <a href="pencarian.html">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </a>
                    </span>
                    <input type="text" class="form-control" placeholder="Type here...">
                </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center d-none d-sm-block">
                    @guest
                        <a class="btn btn-outline-primary btn-sm mb-0 me-3" href="{{ route('login') }}">Join
                            Seller</a>
                    @endguest
                    {{-- @can('isCustomer')
                        <a class="btn btn-outline-primary btn-sm mb-0 me-3" href="{{ route('seller.register') }}">Join
                            Seller</a>
                    @endcan --}}
                    @can('isSeller')
                        <a class="btn btn-outline-primary btn-sm mb-0 me-3"
                            href="{{ route('filament.seller.pages.dashboard') }}">{{ Auth::user()->customers->sellers->shops->name }}</a>
                    @endcan
                </li>
                <li class="nav-item dropdown pe-2 ps-3 d-flex align-items-center d-none d-sm-block pt-2">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                    <span class="item_count"
                        style="font-size: 9px;
                        font-weight: 500;
                        width: 15px;
                        height: 15px;
                        border-radius: 50%;
                        background: #cb0c9f;
                        color: #fff;
                        display: inline-block;
                        text-align: center;
                        line-height: 15px;
                        position: absolute;
                        top: -1px;
                        right: -1px;">3</span>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 pt-3 pb-1 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="template/assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Pesanan telah sampai</span> Bandung
                                        </h6>
                                        <p class="text-xs text-secondary mb-0 ">
                                            <i class="fa fa-clock me-1"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="template/assets/img/small-logos/logo-spotify.svg"
                                            class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Verifikasi</span> menjadi seller
                                            berhasil
                                        </h6>
                                        <p class="text-xs text-secondary mb-0 ">
                                            <i class="fa fa-clock me-1"></i>
                                            2 hours ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>credit-card</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF"
                                                    fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(453.000000, 454.000000)">
                                                            <path class="color-background"
                                                                d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                opacity="0.593633743"></path>
                                                            <path class="color-background"
                                                                d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            Pembayaran telah dikonfirmasi
                                        </h6>
                                        <p class="text-xs text-secondary mb-0 ">
                                            <i class="fa fa-clock me-1"></i>
                                            2 days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <div class="row px-4">
                                <a href="notifikasi.html" class="btn btn-outline-primary">Lihat Semua</a>
                            </div>
                        </li>
                    </ul>
                </li>
                @auth
                    <li class="nav-item dropdown pe-2 ps-3 d-flex align-items-center d-none d-sm-block pt-2">
                        <a class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="ni ni-basket"></i>
                        </a>
                        <span class="item_count"
                            style="font-size: 9px;font-weight: 500;width: 15px;height: 15px;border-radius: 50%;background: #cb0c9f;color: #fff;display: inline-block;text-align: center;line-height: 15px;position: absolute;top: -1px;right: -1px;">
                            {{ $cartCount->cartItem->sum('qty') }}
                        </span>
                        <ul class="dropdown-menu dropdown-menu-end px-2 pt-3 pb-1 me-sm-n4" style="width: 23rem;"
                            aria-labelledby="dropdownMenuButton">
                            @foreach ($cart->cartItem as $item)
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="row">
                                            <div class="d-flex py-1">
                                                <div class="col-lg-2">
                                                    <div class="my-auto">
                                                        <img src="{{ asset('storage/' . $item->variationSize->photo->directory) }}"
                                                            class="avatar avatar-sm me-3">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <h6 class="text-sm font-weight-normal mb-1">
                                                        {{ $item->variationSize->photo->variation->product->name }}
                                                    </h6>
                                                </div>
                                                <div class="col-lg-3 offset-lg-1">
                                                    <h9 class="text-end">{{ $item->qty }} x <strong>Rp
                                                            {{ number_format($item->variationSize->price, 0, ',', '.') }}</strong>
                                                    </h9>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            <li class="mb-2">
                                <div class="row px-4">
                                    {{-- <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">Checkout</a> --}}
                                </div>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item dropdown pe-2 ps-3 d-flex align-items-center d-none d-sm-block pt-2">
                        <a href="{{ route('login') }}" class="nav-link text-body p-0" id="dropdownMenuButton">
                            <i class="ni ni-basket"></i>
                        </a>
                        <span class="item_count"
                            style="font-size: 9px;font-weight: 500;width: 15px;height: 15px;border-radius: 50%;background: #cb0c9f;color: #fff;display: inline-block;text-align: center;line-height: 15px;position: absolute;top: -1px;right: -1px;">
                            0
                        </span>
                    </li>
                @endauth
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item dropdown pe-2 ps-3 d-flex align-items-center">
                            <a href="{{ route('login') }}" class="nav-link text-body p-0">
                                <i class="fa fa-user me-sm-1"></i>
                                &nbsp;Login
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown pe-2 ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user me-sm-1"></i>
                            &nbsp;{{ Auth::user()->customers->FName }}
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                            aria-labelledby="dropdownMenuButton">
                            <li class="mb-2">
                                {{-- <a class="dropdown-item border-radius-md" href="{{ route('profile') }}"> --}}
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="pesanan.html">
                                    <span>Pesanan Saya</span>
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <span>Logout</span>
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </li>
                    <li class="nav-item d-xl-none pe-2 ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
