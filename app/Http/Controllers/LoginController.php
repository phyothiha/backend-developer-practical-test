<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Facades\ApiResponse;

class LoginController extends Controller
{
    /**
     * Handle authentication request
     *
     * @param  LoginRequest  $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        $request->authenticate();      
      
        return ApiResponse::data(new LoginResource($request->user()))
                        ->success();
                        
        return new LoginResource($request->user());
    }
}
