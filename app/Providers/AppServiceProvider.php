<?php

namespace App\Providers;

use App\Services\InternetServiceProvider\InternetServiceProviderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Services\InternetServiceProvider\ISPPaymentCalculatorInterface;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Controllers\InternetServiceProviderController;
use App\Services\InternetServiceProvider\MptPaymentCalculator;
use App\Services\InternetServiceProvider\OoredooPaymentCalculator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            InternetServiceProviderInterface::class,
            'App\Services\InternetServiceProvider\\'.ucfirst(Request::capture()->segment(2))
        );
        
        $this->app->when(InternetServiceProviderController::class)
                ->needs(ISPPaymentCalculatorInterface::class)
                ->give(function (Application $app) {
                    
                    $provider = Request::capture()->segment(2);
                    
                    switch ($provider) {
                        case 'mpt':
                            return $app->make(MptPaymentCalculator::class);
                            break;
                        
                        case 'ooredoo':
                            return $app->make(OoredooPaymentCalculator::class);
                            break;
                    }
                });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
