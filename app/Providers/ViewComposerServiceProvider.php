<?php

namespace App\Providers;

use Gate;
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
            $path_class = count($path_arr) > 0 && !empty($path_arr[0]) ? str_slug($path_arr[0], '-') : 'home';
            $path_subclass = count($path_arr) > 1 ? $path_class . '-' . str_slug($path_arr[1], '-') : '';

            $classes = "$path_class $path_subclass";
            $view->with('classes', trim($classes));
        });

        view()->composer('*', function($view){
            $view->with('user', \Auth::user());
        });

        view()->composer('projects.*', function($view){
            $current_user =  \Auth::user();

            $params = Route::current()->parameters();
            $user_param = !empty($params['user']) ? $params['user'] : NULL;

            $view->with([
                'owned_by_current_user' => (!empty($user_param) && $user_param->id == $current_user->id),
                'project_user' => $user_param,
            ]);
        });

        view()->composer('people.*', function($view){
            $current_user =  \Auth::user();

            $params = Route::current()->parameters();
            $user_param = !empty($params['user']) ? $params['user'] : NULL;
            $user_profile = !empty($user_param->profile) ? $user_param->profile : NULL;

            $can_edit = Gate::allows('update-profile', $user_profile);

            $view->with([
                'people_user' => $user_param,
                'can_edit' => $can_edit,
            ]);
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
