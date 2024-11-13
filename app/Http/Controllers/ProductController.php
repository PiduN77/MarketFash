<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($name) {}

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

        $totalSold = $product->variations
            ->pluck('photos')
            ->flatten()
            ->pluck('sizes')
            ->flatten()
            ->pluck('orderItems')
            ->flatten()
            ->sum('qty') ?? '0';

        return view('product.index', compact('product', 'relatedProducts', 'totalSold'));
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
