@extends('layouts.main')

@section('content')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12 pb-0">
                <div class="card w-100 h-100 p-0">
                    <div class="overflow-hidden position-relative border-radius-lg ">
                        <div class="card-body position-relative z-index-2 p-0"
                            style="height: 360px; width:1250px; overflow: hidden;">
                            <img src="{{ asset('assets/img/banner.jpg') }}" class="w-100 mh-75 object-fit-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            @foreach ($categories as $category)
                <div class="col-xl-3 col-sm-6 col-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-xl-8 col-9 pe-0">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ $category->name }}</p>
                                        <h6 class="font-weight-bolder mb-0">
                                            {{ number_format($category->products_count / 1) }} produk
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-3 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fa-solid fa-{{ strtolower($category->name) }} text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!--PRODUK POPULER-->
        {{-- <div class="row mt-4">
            <h4 class="text-center my-xl-5 mt-sm-1">TOP PRODUK</h4>
            @forelse($products as $product)
                <div class="col-lg-3 mb-lg-3 mb-5 col-sm-6 col-6">
                    <a href="{{ route('product.show', $product->product_id) }}">
                        <div class="card h-100 z-index-2 card-hover">
                            <div class="card-header h-100 p-0">
                                @php
                                    $firstVariation = $product->variations->first();
                                    $firstPhoto = $firstVariation ? $firstVariation->photos->first() : null;
                                @endphp
                                @if ($firstPhoto)
                                    <img src="{{ asset('storage/' . $firstPhoto->directory) }}"
                                        class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}"
                                        onerror="this.src='{{ asset('template/assets/img/product-placeholder.jpg') }}'">
                                @else
                                    <img src="{{ asset('template/assets/img/product-placeholder.jpg') }}"
                                        class="w-100 h-100 object-fit-cover" alt="No image available">
                                @endif
                            </div>
                            <div class="card-body p-3">
                                <p class="text-xs m-0 ms-2">{{ $product->name }}</p>
                                @php
                                    $lowestPrice = $product->variations
                                        ->flatMap(function ($variation) {
                                            return $variation->photos->flatMap(function ($photo) {
                                                return $photo->sizes;
                                            });
                                        })
                                        ->min('price');
                                @endphp
                                <h6 class="ms-2 mb-0">
                                    @if ($lowestPrice)
                                        Rp {{ number_format($lowestPrice, 0, ',', '.') }}
                                    @else
                                        Harga tidak tersedia
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Tidak ada produk yang tersedia saat ini.
                    </div>
                </div>
            @endforelse
        </div> --}}
        <!--PRODUK POPULER END-->

        <!--PROMO-->
        {{-- <div class="row mt-xl-5 mt-sm-1">
            <h4 class="text-center mb-5">PROMO BULAN JUNI</h4>
            <div class="col-lg-6 col-12 mb-3">
                <div class="card w-100 h-100 p-0">
                    <div class="overflow-hidden position-relative border-radius-lg ">
                        <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-0">
                            <img src="template/assets/img/promo3.jpg" class="w-100 mh-75">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12 mb-3">
                <div class="card w-100 h-100 p-0">
                    <div class="overflow-hidden position-relative border-radius-lg ">
                        <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-0">
                            <img src="template/assets/img/promo4.jpg" class="w-100 mh-75">
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--PROMO END-->

        <!--PRODUK-->
        <div class="row mt-5">
            <h4 class="text-center mb-5">FOR YOU</h4>
            @forelse($products as $product)
                <div class="col-lg-2 mb-lg-3 mb-5 col-sm-6 col-6">
                    <a href="{{ route('product.show', $product->product_id) }}">
                        <div class="card h-75 z-index-2 card-hover">
                            <div class="card-header p-0" style="height: 260px; overflow: hidden;">
                                @php
                                    $firstVariation = $product->variations->first();
                                    $firstPhoto = $firstVariation ? $firstVariation->photos->first() : null;
                                @endphp
                                @if ($firstPhoto)
                                    <img src="{{ asset('storage/' . $firstPhoto->directory) }}"
                                        class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}"
                                        onerror="this.src='{{ asset('template/assets/img/product-placeholder.jpg') }}'">
                                @else
                                    <img src="{{ asset('template/assets/img/product-placeholder.jpg') }}"
                                        class="w-100 mh-100" alt="No image available">
                                @endif
                            </div>
                            <div class="card-body p-3">
                                <p class="text-xs m-0 ms-2"> {{ $product->name }} </p>
                                @php
                                    $lowestPrice = $product->variations
                                        ->flatMap(function ($variation) {
                                            return $variation->photos->flatMap(function ($photo) {
                                                return $photo->sizes;
                                            });
                                        })
                                        ->min('price');
                                @endphp
                                <h6 class="ms-2 mb-0">
                                    @if ($lowestPrice)
                                        Rp {{ number_format($lowestPrice, 0, ',', '.') }}
                                    @else
                                        Harga tidak tersedia
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Tidak ada produk yang tersedia saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
