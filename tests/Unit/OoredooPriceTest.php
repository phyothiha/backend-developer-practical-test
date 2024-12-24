<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\InternetServiceProvider\Ooredoo;
use App\Services\InternetServiceProvider\MonthlyPaymentCalculator;

class OoredooPriceTest extends TestCase
{
    public function test_default_monthly_price()
    {
        $provider = new Ooredoo;
        $paymentCalculator = new MonthlyPaymentCalculator($provider);
        
        $this->assertEquals(150.00, $paymentCalculator->calculateTotalAmount($provider));
    }
    
    public function test_custom_monthly_price()
    {
        $provider = new Ooredoo;
        $provider->setMonth(5);
        
        $paymentCalculator = new MonthlyPaymentCalculator($provider);
        
        $this->assertEquals(750.00, $paymentCalculator->calculateTotalAmount($provider));
    }
}
