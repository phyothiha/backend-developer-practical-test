<?php

namespace App\Http\Controllers;

use App\Services\InternetServiceProvider\InternetServiceProviderInterface;
use Illuminate\Http\Request;
use App\Services\InternetServiceProvider\PaymentCalculatorInterface;

class InternetServiceProviderController extends Controller
{
    public function getInvoiceAmount(Request $request, InternetServiceProviderInterface $internetServiceProvider, PaymentCalculatorInterface $paymentCalculator)
    {
        $month = $request->input('month', 1);

        $internetServiceProvider->setMonth($month);

        return response()->json([
            'data' => $paymentCalculator->calculateTotalAmount($internetServiceProvider),
        ]);
    }
}
