<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if an authenticated user can successfully log out.
     *
     * @return void
     */
    #[Test]
    public function authenticated_user_can_logout_successfully(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Logout realizado com sucesso',
                 ]);
    }

    /**
     * Test if a guest (unauthenticated user) cannot log out.
     *
     * @return void
     */
    #[Test]
    public function guest_cannot_logout(): void
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401);
    }
}
