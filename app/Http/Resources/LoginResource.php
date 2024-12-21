<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'user'  => new UserResource($this),
            'token' => $this->createToken('authToken')->plainTextToken,
        ];
    }
}
