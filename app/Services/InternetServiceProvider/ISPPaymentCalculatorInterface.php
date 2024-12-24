<?php

namespace App\Services\InternetServiceProvider;

interface ISPPaymentCalculatorInterface
{
    public function calculateTotalAmount(InternetServiceProviderInterface $provider): float;
}