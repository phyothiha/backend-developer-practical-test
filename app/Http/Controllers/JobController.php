<?php

namespace App\Http\Controllers;

use App\Services\EmployeeManagement\Applicant;
use Illuminate\Http\Request;
use App\Facades\ApiResponse;

class JobController extends Controller
{
    public function __construct(public readonly Applicant $applicant)
    {
    }
    
    public function apply(Request $request)
    {
        $data = $this->applicant->applyJob();
        
        return ApiResponse::data($data)
                            ->success();
    }
}
