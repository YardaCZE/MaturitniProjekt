<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {


    }

    public function boot()
    {
        DB::listen(function ($query) {
            Log::info($query->sql);
        });
	if($this->app->environment('production')) {
    		\URL::forceScheme('https');
	}

    }

    /**
     * Bootstrap any application services.
     */

}
