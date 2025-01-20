<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerPolicies();
       

       
        
    }
}
