<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
//    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_admin_can_authenticate_using_the_login_screen()
    {
        $response = $this->post('/login', [
            'email' => "admin@gmail.com",
            'password' => '123456',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::ADMIN_HOME);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test_'.random_int(10, 200).'@rrr.com',
            'phone' => random_int(10, 10000),
            'image' => 'test.png',
            'password' => Hash::make("password"),
            'ref' => 'test'
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test_'.random_int(10, 200).'@rrr.com',
            'phone' => random_int(10, 10000),
            'image' => 'test.png',
            'password' => Hash::make("password"),
            'ref' => 'test'
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
