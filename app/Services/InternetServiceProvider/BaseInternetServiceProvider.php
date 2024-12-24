<?php

namespace App\Services\InternetServiceProvider;

abstract class BaseInternetServiceProvider implements InternetServiceProviderInterface
{
    protected string $operator = 'operator';
    
    protected int $month = 0;
    
    protected float $monthlyFees = 0.00;
    
    public final function __construct()
    {
        if (!isset($this->operator)) {
            throw new \LogicException(get_class($this).' must have a $operator property.');
        }

        if (!isset($this->month)) {
            throw new \LogicException(get_class($this).' must have a $month property.');
        }

        if (!isset($this->monthlyFees)) {
            throw new \LogicException(get_class($this).' must have a $monthlyFees property.');
        }
    }
    
    public function setMonth(int $month): void
    {
        $this->month = $month;
    }
    
    public function getMonth(): int
    {
		return $this->month;
	}

    public function getMonthlyFees(): float
    {
        return $this->monthlyFees;
    }
}