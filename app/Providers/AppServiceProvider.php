<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//max lengs error回避の対策
use Illuminate\Support\Facades\Schema;

//ページネーション
use Illuminate\Pagination\Paginator;

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
        //ページネーション
        Paginator::useBootstrap();

        //herokuでhttpをhttpsに
        if (\App::environment(['production'])) {
            \URL::forceScheme('https');
        }

        //max lengs error 回避対策
        Schema::defaultStringLength(191);
    }
}
