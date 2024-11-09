<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Service\Service;
use Database\Factories\ServiceFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;



    /** @test */
    public function gestionnaire_can_store_service_successfully()
    {
        // Créer un utilisateur avec le rôle de gestionnaire
        $user = User::factory()->create(['role' => 'gestionnaire']);

        // Simuler la connexion de l'utilisateur
        $this->actingAs($user);

        // Effectuer une requête POST pour stocker un service
        $response = $this->post(route('store.service'), [
            'nom_service' => 'Service Test',
        ]);

        // Vérifier que le service a été ajouté à la base de données
        $this->assertDatabaseHas('services', [
            'nom_service' => 'Service Test',
        ]);

        // Vérifier la redirection et le message de notification
        $response->assertRedirect(route('liste.service'));
        $response->assertSessionHas('message', 'Ajout Réussi');
    }


    /** @test */
    public function gestionnaire_cannot_store_service_without_required_fields()
    {
        // Créer un utilisateur avec le rôle de gestionnaire
        $user = User::factory()->create(['role' => 'gestionnaire']);

        // Simuler la connexion de l'utilisateur
        $this->actingAs($user);

        // Effectuer une requête POST sans le champ requis
        $response = $this->post(route('store.service'), [
            'nom_service' => '',
        ]);

        // Vérifier que la validation échoue
        $response->assertSessionHasErrors('nom_service');
    }
}
