<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\InternetServiceProvider\Mpt;
use App\Services\InternetServiceProvider\MonthlyPaymentCalculator;

class MptPriceTest extends TestCase
{
    public function test_default_monthly_price()
    {
        $provider = new Mpt;
        $paymentCalculator = new MonthlyPaymentCalculator($provider);
        
        $this->assertEquals(200.00, $paymentCalculator->calculateTotalAmount($provider));
    }
    
    public function test_custom_monthly_price()
    {
        $provider = new Mpt;
        $provider->setMonth(5);
        
        $paymentCalculator = new MonthlyPaymentCalculator($provider);
        
        $this->assertEquals(1000.00, $paymentCalculator->calculateTotalAmount($provider));
    }
}
