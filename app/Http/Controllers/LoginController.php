<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;

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
      
        return new LoginResource($request->user());
    }
}
