<?php

namespace App\Http\Controllers;

use App\Services\InternetServiceProvider\InternetServiceProviderInterface;
use Illuminate\Http\Request;
use App\Services\InternetServiceProvider\ISPPaymentCalculatorInterface;

class InternetServiceProviderController extends Controller
{
    protected ISPPaymentCalculatorInterface $paymentCalculator;

    public function __construct(ISPPaymentCalculatorInterface $paymentCalculator)
    {
        $this->paymentCalculator = $paymentCalculator;
    }
    
    public function getInvoiceAmount(Request $request, InternetServiceProviderInterface $internetServiceProvider)
    {
        $month = $request->input('month', 1);

        $internetServiceProvider->setMonth($month);

        return response()->json([
            'data' => $this->paymentCalculator->calculateTotalAmount($internetServiceProvider),
        ]);
    }
}
