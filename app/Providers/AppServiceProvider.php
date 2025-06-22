<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Share data ke semua view, terutama untuk notifikasi stok produk
        View::composer('*', function ($view) {
            $lowStockProducts = Product::where('stock', '<', 5)->get();
            $view->with('lowStockProducts', $lowStockProducts);
        });
    }
}
