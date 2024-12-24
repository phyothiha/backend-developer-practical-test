<?php

namespace App\Http\Controllers;

use App\Services\EmployeeManagement\Staff;
use App\Facades\ApiResponse;

class StaffController extends Controller
{
    public function __construct(public readonly Staff $staff)
    {
    }
    
    public function payroll()
    {
        $data = $this->staff->salary();
            
        return ApiResponse::data($data)
                            ->success();
    }
}
