<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

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
        // Vite::prefetch(concurrency: 3);
        Inertia::share('auth', function () {
            return [
                'agence' => Auth::guard('agence')->user() ? [
                    'id' => Auth::guard('agence')->user()->id,
                    'raison_sociale' => Auth::guard('agence')->user()->raison_sociale,
                    'email' => Auth::guard('agence')->user()->email,
                ] : null,
                'visiteur' => Auth::guard('visiteur')->user() ? [
                    'id' => Auth::guard('visiteur')->user()->id,
                    'email' => Auth::guard('visiteur')->user()->email,
                ] : null,
            ];
        });
        Inertia::share('flash', function () {
            return [
                'success' => Session::get('success'),
                'error' => Session::get('error'),
            ];
        });
    }
}
