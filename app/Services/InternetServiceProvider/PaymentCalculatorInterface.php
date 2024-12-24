<?php

namespace App\Services\InternetServiceProvider;

interface PaymentCalculatorInterface
{
    public function calculateTotalAmount(InternetServiceProviderInterface $provider): float;
}