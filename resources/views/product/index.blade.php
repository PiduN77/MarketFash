@extends('layouts.main')

@section('content')
    <div class="container-fluid py-4">
        <form action="{{ route('cart.store', $product->product_id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 text-center">
                                    @if ($product->variations->first() && $product->variations->first()->photos->first())
                                        <img class="w-100 mh-75 border-radius-lg shadow-lg mx-auto"
                                            src="{{ asset('storage/' . $product->variations->first()->photos->first()->directory) }}"
                                            alt="{{ $product->name }}">
                                    @else
                                        <img class="w-100 mh-75 border-radius-lg shadow-lg mx-auto"
                                            src="{{ asset('template/assets/img/product-placeholder.jpg') }}"
                                            alt="No image available">
                                    @endif
                                    <div class="my-gallery d-flex mt-4 pt-2" itemscope
                                        itemtype="http://schema.org/ImageGallery">
                                        @foreach ($product->variations as $variation)
                                            @foreach ($variation->photos as $photo)
                                                <figure itemprop="associatedMedia" itemscope
                                                    itemtype="http://schema.org/ImageObject">
                                                    <a href="{{ asset('storage/' . $photo->directory) }}"
                                                        itemprop="contentUrl" data-size="500x600">
                                                        <img class="w-75 min-height-100 max-height-100 border-radius-lg shadow"
                                                            src="{{ asset('storage/' . $photo->directory) }}"
                                                            itemprop="thumbnail" alt="{{ $product->name }}">
                                                    </a>
                                                </figure>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-7 mx-auto mt-3">
                                    <h3 class="mt-lg-0 mt-5">{{ $product->name }}</h3>
                                    <div class="rating">
                                        <span class="pr-3"><b>Terjual </b>{{ $totalSold ?? '0' }}
                                            &nbsp;&nbsp;&nbsp;</span>
                                        <i class="fas fa-star" aria-hidden="true"></i>
                                        <span><b>{{ $product->rating ?? '0' }} </b>({{ $product->rating_count ?? '0' }}
                                            rating)</span>
                                    </div>
                                    <br>
                                    @php
                                        $minPrice = $product->variations
                                            ->flatMap(function ($variation) {
                                                return $variation->photos->flatMap(function ($photo) {
                                                    return $photo->sizes->pluck('price');
                                                });
                                            })
                                            ->min();
                                    @endphp
                                    <h2>
                                        @if ($minPrice)
                                            Rp {{ number_format($minPrice, 0, ',', '.') }}
                                        @else
                                            Price not available
                                        @endif
                                    </h2>
                                    <br>
                                    <!-- Color selection -->
                                    <div class="mb-4">
                                        <strong class="h7">Pilih warna:</strong>
                                        <div class="d-flex flex-wrap gap-2" id="colorOptions">
                                            @foreach ($product->variations as $variation)
                                                @php
                                                    $hasStock = $variation->photos->flatMap->sizes->sum('stock') > 0;
                                                @endphp
                                                <label
                                                    class="btn btn-outline-primary color-option {{ $hasStock ? '' : 'disabled' }}"
                                                    @if (!$hasStock) title="Stok habis" @endif>
                                                    <input type="radio" name="color" value="{{ $variation->color }}"
                                                        class="d-none" data-color="{{ $variation->color }}"
                                                        {{ $hasStock ? '' : 'disabled' }}>
                                                    {{ $variation->color }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Size selection -->
                                    <div class="mb-4">
                                        <strong class="h7">Pilih ukuran sepatu:</strong>
                                        <div class="d-flex flex-wrap gap-2" id="sizeOptions">
                                            @php
                                                $allSizes = $product->variations
                                                    ->flatMap(function ($variation) {
                                                        return $variation->photos->flatMap(function ($photo) {
                                                            return $photo->sizes->pluck('size');
                                                        });
                                                    })
                                                    ->unique()
                                                    ->sort()
                                                    ->values();
                                            @endphp

                                            @foreach ($allSizes as $size)
                                                <label class="btn btn-outline-primary size-option disabled"
                                                    data-size="{{ $size }}">
                                                    <input type="radio" name="size" value="{{ $size }}"
                                                        class="d-none" data-size="{{ $size }}" disabled>
                                                    {{ $size }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="nav-wrapper position-relative end-0 mt-3">
                                            <ul class="nav nav-tabs nav-fill p-1" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link mb-0 px-0 py-2 active" id="home-tab"
                                                        data-bs-toggle="tab" data-bs-target="#profile" role="tab"
                                                        aria-controls="home" aria-selected="true" style="color: #495057;">
                                                        Detail
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link mb-0 px-0 py-2" data-bs-toggle="tab" href="#alamat"
                                                        role="tab" aria-controls="code" aria-selected="false"
                                                        style="color: #495057;" tabindex="-1">
                                                        Info Penting
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                                aria-labelledby="profile-tab">
                                                <label class="mt-3">Description</label>
                                                <ul class="list-group">
                                                    <li class="list-group-item">Kondisi:
                                                        {{ $product->condition ?? 'Baru' }}
                                                    </li>
                                                    <li class="list-group-item">Min. Pemesanan:
                                                        {{ $product->min_order ?? '1' }} Buah</li>
                                                    <li class="list-group-item">Etalase:
                                                        {{ $product->category->name ?? 'Semua Etalase' }}</li>
                                                    <li class="list-group-item">{{ $product->desc }}</li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane fade" id="alamat" role="tabpanel"
                                                aria-labelledby="alamat-tab">
                                                <!-- Add your warranty and shipping info here -->
                                            </div>
                                        </div>
                                        <hr class="horizontal dark">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <h5 class="mt-lg-0 mt-1">Atur Jumlah</h5>
                                    <div class="text-sm mb-2" id="stockDisplay">
                                        <div id="totalStockDisplay">
                                            @php
                                                $totalStock = $product->variations
                                                    ->flatMap(function ($variation) {
                                                        return $variation->photos->flatMap(function ($photo) {
                                                            return $photo->sizes->pluck('stock');
                                                        });
                                                    })
                                                    ->sum();

                                                $minPrice =
                                                    $product->variations
                                                        ->flatMap(function ($variation) {
                                                            return $variation->photos->flatMap(function ($photo) {
                                                                return $photo->sizes->pluck('price');
                                                            });
                                                        })
                                                        ->min() ?? 0;
                                            @endphp
                                            Stok Total: {{ $totalStock }}
                                        </div>
                                        <div id="selectedStockDisplay">
                                            Pilih warna dan ukuran untuk melihat stok spesifik
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-9">
                                            <label>Quantity</label>
                                            <div class="form-group">
                                                @if ($totalStock > 0)
                                                    <div class="d-flex align-items-center">
                                                        <div class="input-group mb-0">
                                                            <button class="btn btn-outline-primary mb-0" type="button"
                                                                id="decreaseQuantity">-</button>
                                                            <input type="numeric"
                                                                class="form-control text-center border-secondary"
                                                                id="quantity" min="1" name="qty"
                                                                max="{{ $totalStock }}" value="1">
                                                            <button class="btn btn-outline-primary mb-0" type="button"
                                                                id="increaseQuantity">+</button>
                                                        </div>
                                                    </div>
                                                    <div id="stockError" class="invalid-feedback">
                                                        Quantity cannot exceed available stock
                                                    </div>
                                                @else
                                                    <div class="alert alert-warning">Out of Stock</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-4">
                                            <span>Subtotal</span>
                                        </div>
                                        <div class="col-8 text-end">
                                            <h5 id="subtotal">Rp {{ number_format($minPrice, 0, ',', '.') }}</h5>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-12">
                                            @auth
                                                <button class="btn bg-gradient-primary mb-0 mt-lg-auto w-100" type="submit">
                                                    <i class="fas fa-shopping-cart me-2"></i> Add to cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}"
                                                    class="btn bg-gradient-primary mb-0 mt-lg-auto w-100">
                                                    <i class="fas fa-shopping-cart me-2"></i> Add to cart
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        {{-- <div class="row mt-6">
            <label class="h4">Lainnya di toko ini</label>
            <div class="row mt-5">
                @foreach ($relatedProducts as $relatedProduct)
                    <div class="col-lg-2 mb-lg-3 mb-5 col-sm-6">
                        <a href="{{ route('product.show', ['id' => $product->product_id]) }}">
                            <div class="card h-100 z-index-2">
                                <div class="card-header h-100 p-0">
                                    @if ($relatedProduct->variations->first() && $relatedProduct->variations->first()->photos->first())
                                        <img src="{{ asset('storage/' . $relatedProduct->variations->first()->photos->first()->directory) }}"
                                            class="w-100 h-100 object-fit-cover" alt="{{ $relatedProduct->name }}">
                                    @else
                                        <img src="{{ asset('template/assets/img/product-placeholder.jpg') }}"
                                            class="w-100 h-100 object-fit-cover" alt="No image available">
                                    @endif
                                </div>
                                <div class="card-body p-3">
                                    <p class="text-xs m-0 ms-2">{{ $relatedProduct->name }}</p>
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
                @endforeach
            </div>
        </div> --}}
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM elements
            const colorLabels = document.querySelectorAll('#colorOptions label');
            const sizeLabels = document.querySelectorAll('#sizeOptions label');
            const selectedStockDisplay = document.getElementById('selectedStockDisplay');
            const quantityInput = document.getElementById('quantity');
            const subtotalElement = document.getElementById('subtotal');
            const decreaseBtn = document.getElementById('decreaseQuantity');
            const increaseBtn = document.getElementById('increaseQuantity');
            const stockError = document.getElementById('stockError');
            const addToCartForm = document.querySelector('form');

            // Variables
            let selectedColor = null;
            let selectedSize = null;
            let currentStock = {{ $totalStock }};
            let currentPrice = {{ $minPrice }};

            function updateStockDisplay() {
                if (!selectedColor) {
                    selectedStockDisplay.textContent = 'Pilih warna dan ukuran untuk melihat stok spesifik';
                    return;
                }

                if (!selectedSize) {
                    const colorStock = calculateColorStock(selectedColor);
                    selectedStockDisplay.textContent = `Stok untuk warna ${selectedColor}: ${colorStock}`;
                    return;
                }

                const specificStock = getSpecificStock(selectedColor, selectedSize);
                selectedStockDisplay.textContent = `Stok ${selectedColor} ukuran ${selectedSize}: ${specificStock}`;

                currentStock = specificStock;
                quantityInput.max = currentStock;
                if (parseInt(quantityInput.value) > currentStock) {
                    quantityInput.value = currentStock;
                }
            }

            function calculateColorStock(color) {
                if (!variationData[color]) return 0;
                return variationData[color].sizes.reduce((total, size) => total + size.stock, 0);
            }

            function getSpecificStock(color, size) {
                if (!variationData[color]) return 0;
                const sizeData = variationData[color].sizes.find(s => s.size === size);
                return sizeData ? sizeData.stock : 0;
            }

            function updateSizeOptions(color) {
                if (!variationData[color]) return;

                const availableSizes = variationData[color].sizes.reduce((acc, item) => {
                    if (!acc[item.size]) {
                        acc[item.size] = item;
                    } else {
                        acc[item.size].stock += item.stock;
                    }
                    return acc;
                }, {});

                sizeLabels.forEach(label => {
                    const size = label.dataset.size;
                    const input = label.querySelector('input');

                    if (availableSizes[size] && availableSizes[size].stock > 0) {
                        label.classList.remove('disabled');
                        label.classList.add('available');
                        input.disabled = false;
                        label.title = `Stok: ${availableSizes[size].stock}`;
                    } else {
                        label.classList.add('disabled');
                        label.classList.remove('available');
                        input.disabled = true;
                        label.title = 'Stok habis';
                        if (input.checked) input.checked = false;
                    }
                });

                selectedSize = null;
                updateStockDisplay();
            }

            function updateSubtotal() {
                let quantity = parseInt(quantityInput.value);

                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                    quantityInput.value = 1;
                }

                if (quantity > currentStock) {
                    quantityInput.classList.add('is-invalid');
                    stockError.style.display = 'block';
                    quantity = currentStock;
                    quantityInput.value = currentStock;
                } else {
                    quantityInput.classList.remove('is-invalid');
                    stockError.style.display = 'none';
                }

                const subtotal = quantity * currentPrice;
                subtotalElement.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            }

            // Event Listeners
            colorLabels.forEach(label => {
                label.addEventListener('click', function() {
                    if (label.classList.contains('disabled')) return;

                    colorLabels.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    const input = this.querySelector('input');
                    selectedColor = input.value;
                    input.checked = true; // Ensure the radio input is checked
                    updateSizeOptions(selectedColor);
                });
            });

            sizeLabels.forEach(label => {
                label.addEventListener('click', function() {
                    if (label.classList.contains('disabled')) return;

                    sizeLabels.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    const input = this.querySelector('input');
                    selectedSize = input.dataset.size;
                    input.checked = true; // Ensure the radio input is checked

                    if (selectedColor && selectedSize) {
                        const sizeData = variationData[selectedColor].sizes.find(s => s.size ===
                            selectedSize);
                        if (sizeData) {
                            currentPrice = sizeData.price;
                            updateStockDisplay();
                            updateSubtotal();
                        }
                    }
                });
            });

            decreaseBtn.addEventListener('click', function() {
                if (quantityInput.value > 1) {
                    quantityInput.value--;
                    updateSubtotal();
                }
            });

            increaseBtn.addEventListener('click', function() {
                if (quantityInput.value < currentStock) {
                    quantityInput.value++;
                    updateSubtotal();
                }
            });

            quantityInput.addEventListener('change', updateSubtotal);
            quantityInput.addEventListener('input', updateSubtotal);

            quantityInput.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });

            // Add to Cart Functionality
            addToCartForm.addEventListener('submit', function(e) {
                e.preventDefault();

                if (!selectedColor || !selectedSize) {
                    Swal.fire({
                        title: 'Perhatian!',
                        text: 'Silakan pilih warna dan ukuran terlebih dahulu',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    return;
                }

                const quantity = parseInt(quantityInput.value);
                if (isNaN(quantity) || quantity < 1 || quantity > currentStock) {
                    Swal.fire({
                        title: 'Perhatian!',
                        text: 'Jumlah tidak valid',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    return;
                }

                // Create FormData object
                const formData = new FormData(this);

                // Add CSRF token
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                // Disable submit button to prevent double submission
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data); // Debug log

                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Produk telah ditambahkan ke keranjang',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error); // Debug log

                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menambahkan ke keranjang',
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                    })
                    .finally(() => {
                        // Re-enable submit button
                        submitButton.disabled = false;
                    });
            });

            // Initial update
            updateStockDisplay();
            updateSubtotal();
        });
    </script>

    <script type="text/javascript">
        const variationData = {
            @foreach ($product->variations as $variation)
                '{{ $variation->color }}': {
                    sizes: [
                        @foreach ($variation->photos as $photo)
                            @foreach ($photo->sizes as $size)
                                {
                                    size: '{{ $size->size }}',
                                    stock: {{ $size->stock }},
                                    price: {{ $size->price }}
                                },
                            @endforeach
                        @endforeach
                    ]
                },
            @endforeach
        };
    </script>
@endsection
