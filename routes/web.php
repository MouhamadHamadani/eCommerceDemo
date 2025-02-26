<?php

use App\Livewire\CartPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Products;
use App\Livewire\ProductDetails;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
});


 
Route::get('/', Home::class)->name('home');
Route::get('/products', Products::class)->name('products');
Route::get('/product/{slug}', ProductDetails::class)->name('product-details');
Route::get('/cart', CartPage::class)->name('cart');