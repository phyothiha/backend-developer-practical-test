<?php

namespace App\Providers;

use App\Services\InternetServiceProvider\InternetServiceProviderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Services\InternetServiceProvider\PaymentCalculatorInterface;
use App\Services\InternetServiceProvider\MonthlyPaymentCalculator;
use App\Http\ApiResponse;

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
        
        $this->app->bind(
            PaymentCalculatorInterface::class,
            MonthlyPaymentCalculator::class,
        );
        
        $this->app->bind('api-response', function () {
            return new ApiResponse;
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
