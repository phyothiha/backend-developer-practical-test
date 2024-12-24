<?php

namespace App\Http\Controllers;

use App\Services\InternetServiceProvider\InternetServiceProviderInterface;
use Illuminate\Http\Request;
use App\Services\InternetServiceProvider\PaymentCalculatorInterface;
use App\Facades\ApiResponse;

class InternetServiceProviderController extends Controller
{
    public function getInvoiceAmount(Request $request, InternetServiceProviderInterface $internetServiceProvider, PaymentCalculatorInterface $paymentCalculator)
    {
        $month = $request->input('month', 1);

        $internetServiceProvider->setMonth($month);

        return ApiResponse::data($paymentCalculator->calculateTotalAmount($internetServiceProvider))
                            ->success();
    }
}
