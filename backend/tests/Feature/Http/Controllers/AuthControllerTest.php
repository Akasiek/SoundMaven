<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    protected $defaultHeaders = [
        'Accept' => 'application/json',
    ];

    protected $withCredentials = true;

    public function test_can_register()
    {
        $userData = User::factory()->make()->toArray();

        $response = $this->post('/register', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => 'test12345',
            'password_confirmation' => 'test12345',
        ]);

        $response->assertCreated();
    }

    public function test_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('test12345'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'test12345',
        ]);

        $response->assertOk();
    }

    public function test_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/logout');

        $response->assertNoContent();
    }

    public function test_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('test12345'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'invalidPassword',
        ]);

        $response->assertUnprocessable();
    }

    public function test_cannot_register_with_invalid_password()
    {
        $userData = User::factory()->make()->toArray();

        $response = $this->post('/register', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => 'test',
            'password_confirmation' => 'test',
        ]);

        $response->assertUnprocessable();
    }
}
