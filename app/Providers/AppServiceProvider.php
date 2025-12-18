<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    // ... method register tetap sama ...

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https'); // <--- Gunakan tanpa backslash
        }
    }
}
