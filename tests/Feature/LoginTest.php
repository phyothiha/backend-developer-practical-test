<?php

namespace Tests\Feature;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_users_can_authenticate_using_email(): void
    {
        $user = User::factory()->create();
        
        $response = $this->postJson('/api/login', [
            'id' => $user->email,
            'password' => '654321'
        ]);
        
        $this->assertAuthenticated();
        
        $response->assertOk();
    }
    
    public function test_users_can_authenticate_using_name(): void
    {
        $user = User::factory()->create();
        
        $response = $this->postJson('/api/login', [
            'id' => $user->name,
            'password' => '654321'
        ]);
        
        $this->assertAuthenticated();
        
        $response->assertOk();
    }
    
    public function test_users_cannot_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();
        
        $response = $this->postJson('/api/login', [
            'id' => $user->name,
            'password' => 'password'
        ]);
    
        $this->assertGuest();
        
        $response->assertUnauthorized();
    }
    
    public function test_authenticated_users_get_response_which_contains_token_key_in_body()
    {
        $user = User::factory()->create();
        
        $response = $this->postJson('/api/login', [
            'id' => $user->name,
            'password' => '654321'
        ]);
     
        $response
            ->assertOk()
            ->assertJson(function (AssertableJson $json) {
                $json->has('data.token')
                    ->etc();
            });
    }
}
