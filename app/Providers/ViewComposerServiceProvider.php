<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Provide the master layout with CSS classes based on the current path
        view()->composer('layouts.app', function($view){
            $path = Route::currentRouteName();
            $path_arr = explode('.', $path);
            $path_class = str_slug($path_arr[0], '-');
            $path_subclass = count($path_arr > 1) ? $path_class . '-' . str_slug($path_arr[1], '-') : '';

            $classes = "$path_class $path_subclass";
            $view->with('classes', $classes);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}