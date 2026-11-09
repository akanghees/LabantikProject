<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LandingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Bagikan $s (semua setting + nilai bawaan) ke layout dan view landing.
        // Memakai composer (lazy) agar tidak menyentuh database saat `artisan migrate`.
        View::composer(['layouts.*', 'landing.*', 'documentations.*'], function ($view) {
            $view->with('s', Setting::forSite());
        });
    }
}
