<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $notifications = Notification::where('user_id', Auth::user()->id)->where('status', 0)->get();
                // dd($notifications);
                $view->with('notifications', $notifications);
                // View::share('notifications', $notifications);
            }
        });
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

    }
}
