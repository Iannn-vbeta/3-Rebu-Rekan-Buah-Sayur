<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return view('auth.login');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->id_role == 1) {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->id_role == 2) {
            return redirect()->route('user.dashboard');
        }
    }
    return view('auth.login');
});

Route::middleware(['auth', 'role:1'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

});

Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/user/dashboard', [ProductController::class, 'index'])->name('user.dashboard');
    Route::get('/user/profile', [UserController::class, 'edit'])->name('user.profile.edit');
    Route::put('/user/profile', [UserController::class, 'update'])->name('user.profile.update');

    // Cart
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::put('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'showForm'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    Route::get('/orders', [OrderController::class, 'userOrders'])->name('orders.user');
    Route::post('/midtrans/callback', [PaymentController::class, 'handleCallback']);

});


require __DIR__.'/auth.php';