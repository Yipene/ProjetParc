<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_assign_role_to_user()
    {
        // Crée un utilisateur et authentifie
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // Crée un autre utilisateur
        $user = User::factory()->create(['role' => 'technicien']);

        // Assigne un nouveau rôle
        $response = $this->post("/user/{$user->id}/assign-role", [
            'role' => 'gestionnaire',
        ]);

        // Vérifie la réponse
        $response->assertStatus(200);
        $this->assertEquals('gestionnaire', $user->fresh()->role);
    }
}
