<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MasukanControlller;
use App\Http\Controllers\User\PageController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AkunUserController;
use App\Http\Controllers\Admin\AkunAdminController;
use App\Http\Controllers\Admin\ListProductController;
use App\Http\Controllers\Admin\OrderDiAntarController;
use App\Http\Controllers\Admin\OrderDiTempatController;

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
            return redirect()->route('admin.dashboard')->with('refresh', true);
        } elseif (Auth::user()->id_role == 2) {
            return redirect()->route('user.home')->with('refresh', true);
        }
    }
    return redirect()->route('login');
})->name('redirect.after.login');

Route::middleware('guest')->group(function () {
    Route::get('/admin/dashboard', function () {
        return redirect()->route('login');
    });
    Route::get('/user/home', function () {
        return redirect()->route('login');
    });
});

Route::fallback(function () {
    if (Auth::check()) {
        if (Auth::user()->id_role == 1) {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->id_role == 2) {
            return redirect()->route('user.home');
        }
    }
    return redirect()->route('login');
});

Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('products', [ListProductController::class, 'index'])->name('product.index');
    Route::post('products', [ListProductController::class, 'store'])->name('product.store');
    Route::put('products/{id}', [ListProductController::class, 'update'])->name('product.update');
    Route::delete('products/{id}', [ListProductController::class, 'destroy'])->name('product.destroy');
    Route::get('products/search', [ListProductController::class, 'search'])->name('product.search');

    Route::get('users', [AkunUserController::class, 'index'])->name('user.index');
    Route::post('users', [AkunUserController::class, 'store'])->name('user.store');
    Route::put('users/{id}', [AkunUserController::class, 'update'])->name('user.update');
    Route::delete('users/{id}', [AkunUserController::class, 'destroy'])->name('user.destroy');
    Route::get('users/search', [AkunUserController::class, 'search'])->name('user.search');

    Route::get('admin', [AkunAdminController::class, 'index'])->name('admin.index');
    Route::post('admin', [AkunAdminController::class, 'store'])->name('admin.store');
    Route::put('admin/{id}', [AkunAdminController::class, 'update'])->name('admin.update');
    Route::delete('admin/{id}', [AkunAdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('admin/search', [AkunAdminController::class, 'search'])->name('admin.search');
    
    Route::get('/status-diantar', [OrderDiAntarController::class, 'index'])->name('order.diantar');
    Route::put('/status-diantar/{id}', [OrderDiAntarController::class, 'update'])->name('order.diantar.update');
    Route::get('/status-diantar/search', [OrderDiAntarController::class, 'search'])->name('order.diantar.search');

    Route::get('/status-ditempat', [OrderDiTempatController::class, 'index'])->name('order.ditempat');
    Route::put('/status-ditempat/{id}', [OrderDiTempatController::class, 'update'])->name('order.ditempat.update');
    Route::get('/status-ditempat/search', [OrderDiTempatController::class, 'search'])->name('order.ditempat.search');

    Route::get('/masukan-admin', [MasukanControlller::class, 'showMasukan'])->name('admin.masukan');

});

Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/user/home', [PageController::class, 'index'])->name('user.home');
    Route::get('/user/product', [ProductController::class, 'index'])->name('user.dashboard');
    Route::get('/user/profile', [UserController::class, 'edit'])->name('user.profile.edit');
    Route::put('/user/profile', [UserController::class, 'update'])->name('user.profile.update');
    
    Route::get('/masukan', [MasukanControlller::class, 'index'])->name('user.masukan');
    Route::post('/masukan', [MasukanControlller::class, 'store'])->name('masukan.store');

    // Cart
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::put('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'showForm'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    Route::get('/orders', [OrderController::class, 'userOrders'])->name('orders.user');
    Route::post('/midtrans/callback', [PaymentController::class, 'handleCallback'])->name('midtrans.callback')->withoutMiddleware(['web', 'csrf']);
    Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification'])->name('midtrans.notification')->withoutMiddleware(['web', 'csrf']);

});


require __DIR__.'/auth.php';