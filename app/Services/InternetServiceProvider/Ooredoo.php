<?php

namespace App\Services\InternetServiceProvider;

class Ooredoo extends BaseInternetServiceProvider
{
    protected string $operator = 'ooredoo';

    protected float $monthlyFees = 150.00;
}