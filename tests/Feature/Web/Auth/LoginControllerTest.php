<?php

namespace Tests\Feature\Web\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /** @test */
    public function we_can_access_admin_login_page()
    {
        $this->get(route('login'))
            ->assertSuccessful();
    }

    /** @test */
    public function we_cannot_access_to_back_office_if_unauthenticated()
    {
        $this->get(route('users.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function there_are_errors_in_session_if_auth_attempts_failed()
    {
        $user = User::factory()->create();

        $this->from(route('login'))
            ->post(route('login.create'), [
                'email' => $user->email,
                'password' => 'WRONG_PWD',
            ])
            ->assertSessionHasErrors([
                'email' => 'Ces identifiants ne correspondent pas à nos enregistrements'
            ]);
    }

    /** @test */
    public function we_are_redirected_to_login_when_we_logout()
    {
        $this->actingAsUser()
            ->get(route('logout'))
            ->assertRedirect(route('login'));
    }
}
