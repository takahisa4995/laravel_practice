<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 商用環境以外の場合、SQLログを出力させます
        if (config('app.env') !== 'production') {
            \DB::Listen(function ($query) {
                \Log::info("Query Time:{$query->time}s] $query->sql");
            });
        }
    }
}
