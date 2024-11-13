<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Product;

Auth::routes(['verify' => true]);

Route::get('/', function () {
    $products = Product::with(['variations.photos.sizes'])
        ->where('status', 'Publish')
        ->get();

    $categories = Category::withCount('products')->get();

    return view('dashboard', compact('products', 'categories'));
})->name('index');

Route::controller(MainController::class)->group(function () {
    Route::get('/product/{id}',  'show')->name('product.show');
});

Route::resource('otp', OtpController::class);
Route::resource('profile', ProfileController::class);
Route::resource('address', AddressController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('api')->group(function () {
    Route::get('/province', [ApiController::class, 'getProvince']);
    Route::get('/kabupaten/{provinsi}', [ApiController::class, 'getKabupaten']);
    Route::get('/kecamatan/{kabupaten}', [ApiController::class, 'getKecamatan']);
    Route::get('/kelurahan/{kecamatan}', [ApiController::class, 'getKelurahan']);
    Route::get('/kodepos/{kelurahan}', [ApiController::class, 'getKodePos']);
});
