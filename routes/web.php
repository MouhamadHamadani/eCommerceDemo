<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Products;

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