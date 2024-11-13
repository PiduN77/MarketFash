<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['variations.photos.sizes'])
            ->where('status', 'Publish')
            ->get();

        $categories = Category::withCount('products')->get();

        if (Auth::check()) {
            $cart = Cart::where('customer_id', Auth::user()->customers->customer_id)
                ->with(['cartItem' => function ($query) {
                    $query->take(3); // Membatasi 3 item
                    $query->with(['variationSize.photo.variation.product']); // Eager loading relasi
                }])
                ->first();

            $cartCount = Cart::firstOrCreate([
                'customer_id' => Auth::user()->customers->customer_id
            ]);

            return view('dashboard', compact('products', 'categories', 'cart', 'cartCount'));
        }
        
        return view('dashboard', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $product = Product::with([
            'variations' => function ($query) {
                $query->whereHas('photos.sizes');
            },
            'variations.photos.sizes',
            'shop',
            'category'
        ])
            ->findOrFail($id);

        $relatedProducts = Product::with([
            'variations' => function ($query) {
                $query->whereHas('photos.sizes');
            },
            'variations.photos.sizes'
        ])
            ->where('shop_id', $product->shop_id)
            ->where('product_id', '!=', $id)
            ->limit(12)
            ->get();

        if (Auth::check()) {
            $cartCount = Cart::firstOrCreate([
                'customer_id' => Auth::user()->customers->customer_id
            ]);

            $cart = Cart::where('customer_id', Auth::user()->customers->customer_id)
                ->with(['cartItem' => function ($query) {
                    $query->take(3); // Membatasi 3 item
                    $query->with(['variationSize.photo.variation.product']); // Eager loading relasi
                }])
                ->first();

            return view('main.product.index', compact('product', 'relatedProducts', 'cart', 'cartCount'));
        }
        return view('main.product.index', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
