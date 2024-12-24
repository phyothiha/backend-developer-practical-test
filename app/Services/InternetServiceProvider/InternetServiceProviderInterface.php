<?php

namespace App\Services\InternetServiceProvider;

interface InternetServiceProviderInterface
{
    public function setMonth(int $month): void;
    
    public function getMonth(): int;
    
	public function getMonthlyFees(): float;
}