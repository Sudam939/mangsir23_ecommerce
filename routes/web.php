<?php

use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/google-login', [UserController::class, 'google_login'])->name('google_login');
Route::get('/google/login', [UserController::class, 'google_callback']);

Route::get('/', [PageController::class, 'home'])->name('home');
Route::post('/vendor-request', [PageController::class, 'vendor_request'])->name('vendor_request');
Route::get('/compare', [PageController::class, 'compare'])->name('compare');
Route::get('/vendor/{id}', [PageController::class, 'vendor'])->name('vendor');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
