<?php

use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

Route::get('/google-login', [UserController::class, 'google_login'])->name('google_login');
Route::get('/google/login', [UserController::class, 'google_callback']);

Route::get('/', [PageController::class, 'home'])->name('home');
Route::post('/vendor-request', [PageController::class, 'vendor_request'])->name('vendor_request');
Route::get('/compare', [PageController::class, 'compare'])->name('compare');
Route::get('/vendor/{id}', [PageController::class, 'vendor'])->name('vendor');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user-profile', [UserController::class, 'profile'])->name('profile');

    Route::post('add-to-cart', [UserController::class, 'add_to_cart'])->name('add_to_cart');
    Route::get('cart', [UserController::class, 'cart'])->name('cart');
    Route::delete('cart-delete/{id}', [UserController::class, 'cart_delete'])->name('cart_delete');
    Route::put('cart-update/{id}', [UserController::class, 'cart_update'])->name('cart_update');

    Route::post('add-shipping-address', [UserController::class, 'add_shipping_address'])->name('add_shipping_address');

    Route::get('checkout/{id}', [UserController::class, 'checkout'])->name('checkout');
    Route::post('order/{id}', [UserController::class, 'order'])->name('order');
});

Route::get('/order-detail/{id}', function ($id) {
    $order = Order::findOrFail($id);
    $company = Company::first();
    return view('order_detail', compact('order', 'company'));
})->name('order.detail');


Route::get('/order/success', function () {
    $id = Cookie::get('order_id');

    $order = Order::findOrFail($id);
    $order->status = "approved";
    $order->update();

    return redirect()->route('profile');
});

Route::get('/payment/failure', function () {
    toast('Something went wrong', 'error');


    return redirect()->route('profile');
});



Route::get('/category-pdf/{record}', [PdfController::class, 'category'])->name('category.pdf');



require __DIR__ . '/auth.php';
