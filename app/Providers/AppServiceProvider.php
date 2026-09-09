<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // ★1. これをファイル上部に追加

class AppServiceProvider extends ServiceProvider{
    /**
     * Register any application services.
     */
    public function register(): void{
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void{
        Paginator::useBootstrapFour(); // ★2. この1行を追加！
    }
}