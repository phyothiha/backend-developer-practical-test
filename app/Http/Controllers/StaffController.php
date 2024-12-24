<?php

namespace App\Http\Controllers;

use App\Services\EmployeeManagement\Staff;

class StaffController extends Controller
{
    public function __construct(public readonly Staff $staff)
    {
    }
    
    public function payroll()
    {
        $data = $this->staff->salary();
    
        return response()->json([
            'data' => $data
        ]);
    }
}
