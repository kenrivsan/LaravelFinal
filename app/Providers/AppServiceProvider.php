<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL; // 👈 importa URL

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
       
        Paginator::useTailwind();

        
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
