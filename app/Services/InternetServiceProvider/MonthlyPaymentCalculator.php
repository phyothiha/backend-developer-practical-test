<?php

namespace App\Services\InternetServiceProvider;

use App\Services\InternetServiceProvider\PaymentCalculatorInterface;
use App\Services\InternetServiceProvider\InternetServiceProviderInterface;

class MonthlyPaymentCalculator implements PaymentCalculatorInterface
{
    public function calculateTotalAmount(InternetServiceProviderInterface $provider): float
    {
        return $provider->getMonth() * $provider->getMonthlyFees();
    }
}