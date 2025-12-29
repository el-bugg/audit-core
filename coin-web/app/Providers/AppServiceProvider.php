<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- 1. Tambahkan baris ini

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 2. Tambahkan baris ini agar Laravel memaksa HTTPS saat online
        if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https') {
            URL::forceScheme('https');
        }
    }
}