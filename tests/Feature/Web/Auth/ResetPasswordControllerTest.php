<?php

namespace Tests\Feature\Web\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    /** @test */
    public function password_reset_request_page_works()
    {
        $this->get(route('password.request'))
            ->assertSuccessful();
    }

    /** @test */
    public function we_can_show_reset_password()
    {
        $user = User::factory()->create();
        $token = Password::broker()->createToken($user);

        $this->get(route('password.reset', ['token' => $token]))
            ->assertSuccessful();
    }

    /** @test */
    public function we_cannot_validate_the_reset_password_form_if_wrong_data()
    {
        $user = User::factory()->create();
        $token = Password::broker()->createToken($user);

        $this->from(route('password.request'))->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'fakepassword',
            'password_confirmation' => 'fakeconfimation',
        ])
            ->assertSessionHasErrors('password')
            ->assertRedirect(route('password.request'));

        $this->from(route('password.request'))->post(route('password.update'), [
            'token' => $token,
            'email' => 'fake@gmail.com',
            'password' => 'fakepassword',
            'password_confirmation' => 'fakepassword',
        ])
            ->assertSessionHasErrors('email')
            ->assertRedirect(route('password.request'));
    }

    /** @test */
    public function we_can_submit_the_reset_password_form()
    {
        $user = User::factory()->create();
        $token = Password::broker()->createToken($user);

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'fakepassword',
            'password_confirmation' => 'fakepassword',
        ])
            ->assertRedirect('/');
    }
}
