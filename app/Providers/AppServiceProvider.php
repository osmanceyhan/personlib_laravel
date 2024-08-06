<?php

namespace App\Providers;

use App\Models\LeaveTypes;
use App\Models\ModelHasRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


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
        //
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // resource lang menu
        $menuItems  = require base_path('resources/lang/tr/menu.php');
        View::composer('*', function ($view) {
            $users = [];

            $leaveTypes = LeaveTypes::all();

            $view->with('leaveTypes', $leaveTypes);
            if (Auth::check()) {
                $user = User::where('id', Auth::id())->first();
                if ($user) {
                    $users = User::where('company_id', $user->company_id)
                        ->where('id', '!=', $user->id)
                        ->get();
                }
            }

            $view->with('users', $users);
        });

        View::share('menuItems', $menuItems);


        Schema::defaultStringLength(191);
    }
}
