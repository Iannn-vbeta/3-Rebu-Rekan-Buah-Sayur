<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    Route::middleware('web')
        ->group(base_path('routes/web.php'));

    // Tambahkan ini:
    Redirect::macro('toDashboard', function () {
        $user = Auth::user();
        if ($user->id_role == 1) {
            return redirect('/admin/dashboard');
        }
        return redirect('/user/dashboard');
    });
}
}