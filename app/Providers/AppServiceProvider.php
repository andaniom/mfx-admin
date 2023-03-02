<?php

namespace App\Providers;

use App\Models\MenuItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
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
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        View::composer('*', function($view)
        {
            $menuItems = MenuItem::with('children')->whereNull('parent_id')->orderBy('order')->get();
            $view->with('menuItems', $menuItems);
        });
    }
}
