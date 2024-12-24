<?php

namespace App\Services\InternetServiceProvider;

use App\Services\InternetServiceProvider\ISPPaymentCalculatorInterface;
use App\Services\InternetServiceProvider\InternetServiceProviderInterface;

class OoredooPaymentCalculator implements ISPPaymentCalculatorInterface
{
    public function calculateTotalAmount(InternetServiceProviderInterface $provider): float
    {
        return $provider->getMonth() * $provider->getMonthlyFees();
    }
}