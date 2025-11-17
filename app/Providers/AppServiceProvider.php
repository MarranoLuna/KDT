<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 
use App\Models\Courier;

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
        View::composer('dashboard', function ($view) {
            $unvalidated = Courier::with(
                "user",
                "vehicles",
                "vehicles.vehicleType",
                "vehicles.bicycleBrand",
                'vehicles.motorcycleBrand'
                )
            ->where('is_validated', 0)
            ->get();
            $view->with('unvalidated', $unvalidated);
        });
    }
}
