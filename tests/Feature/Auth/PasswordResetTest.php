<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
//    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }
//
    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $user = User::create([
            'name' => 'test',
            'email' => 'test_'.random_int(10, 200).'@rrr.com',
            'phone' => random_int(10, 10000),
            'image' => 'test.png',
            'password' => Hash::make("password"),
            'ref' => 'test'
        ]);

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
