<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // User can authenticate either name or email
            'id' => [
                'required', 
                'string',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (str_contains($value, '@') && ! filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail("The login {$attribute} must be a valid name or email.");
                    }
                },
            ],
            'password' => ['required', 'string'],
        ];
    }
    
    /**
     * Authenticate request credentials
     *
     * @throws \Illuminate\Auth\AuthenticationException
     * @return void
     */
    public function authenticate(): void
    {
        $validated = $this->validated();
        
        $credentials = $this->modifyPayload($validated);
                                
        if (! Auth::attempt($credentials)) {
            throw new AuthenticationException('Invalid credentials');
        }
    }
    
    /**
     * Modify request payload
     *
     * @param  array  $data
     * @return array
     */
    protected function modifyPayload(array $data): array
    {
        // clone and remove `id` key
        $payload = array_filter($data, fn (string $key) => $key != 'id', ARRAY_FILTER_USE_KEY);
        
        // determine payload key 
        $key = filter_var($data['id'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
                
        $payload[$key] = $data['id'];
        
        return $payload;
    }
}
