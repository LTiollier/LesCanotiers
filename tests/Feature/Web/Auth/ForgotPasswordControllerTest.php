<?php

namespace Tests\Feature\Web\Auth;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    /** @test */
    public function we_can_request_a_reset_password_and_an_email_is_sent()
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this
            ->from(route('login'))
            ->followingRedirects()
            ->post(route('password.email'), [
                'email' => $user->email
            ]);

        $response->assertSuccessful();
        $this->assertNotEmpty(DB::table('password_resets')->where('email', $user->email)->first());
        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }
}
