<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Equipement\TypeEquipement;

class StoreTypeTest extends TestCase
{
    use RefreshDatabase;


    public function test_store_type_successfully()
    {
        // Crée un utilisateur gestionnaire
        $gestionnaire = User::factory()->create([
            'role' => 'gestionnaire',
        ]);

        // Simule l'authentification du gestionnaire
        $this->actingAs($gestionnaire);

        // Simule une requête POST avec les données valides
        $response = $this->post(route('store.type'), [
            'nom_type' => 'Ordinateur',
        ]);

        // Vérifie que le type d'équipement a bien été inséré dans la base de données
        $this->assertDatabaseHas('type_equipements', [
            'nom_type' => 'Ordinateur',
        ]);

        // Vérifie que la réponse redirige vers la route souhaitée
        $response->assertRedirect(route('liste.type'));
    }

    public function test_store_type_validation_error()
    {
        // Crée un utilisateur gestionnaire
        $gestionnaire = User::factory()->create([
            'role' => 'gestionnaire',
        ]);

        // Simule l'authentification du gestionnaire
        $this->actingAs($gestionnaire);

        // Simule une requête POST avec des données invalides (sans 'nom_type')
        $response = $this->post(route('store.type'), []);

        // Vérifie que la validation échoue et que des erreurs sont présentes dans la session
        $response->assertSessionHasErrors(['nom_type']);
    }

    public function test_store_type_unique_validation_error()
    {
        // Crée un utilisateur gestionnaire et authentifie-le
        $gestionnaire = User::factory()->create([
            'role' => 'gestionnaire',
        ]);
        $this->actingAs($gestionnaire);

        // Crée un type d'équipement existant dans la base de données
        TypeEquipement::create([
            'nom_type' => 'Ordinateur',
        ]);

        // Simule une requête POST avec un 'nom_type' déjà existant
        $response = $this->post(route('store.type'), [
            'nom_type' => 'Ordinateur',
        ]);

        // Vérifie que la validation échoue pour la règle unique
        $response->assertSessionHasErrors(['nom_type']);
    }

    public function test_gestionnaire_can_store_type_successfully()
    {
        // Crée un utilisateur avec le rôle gestionnaire
        $gestionnaire = User::factory()->create([
            'role' => 'gestionnaire',
        ]);

        // Simule l'authentification de l'utilisateur
        $this->actingAs($gestionnaire);

        // Simule une requête POST avec les données valides
        $response = $this->post(route('store.type'), [
            'nom_type' => 'Ordinateur',
        ]);

        // Vérifie que le type d'équipement a bien été inséré dans la base de données
        $this->assertDatabaseHas('type_equipements', [
            'nom_type' => 'Ordinateur',
        ]);

        // Vérifie que la réponse redirige vers la route souhaitée
        $response->assertRedirect(route('liste.type'));
    }

    public function test_non_gestionnaire_cannot_store_type()
    {
        // Crée un utilisateur avec un rôle autre que gestionnaire (ex : admin ou technicien)
        $user = User::factory()->create([
            'role' => 'technicien',
        ]);

        // Simule l'authentification de cet utilisateur
        $this->actingAs($user);

        // Simule une requête POST pour créer un type d'équipement
        $response = $this->post(route('store.type'), [
            'nom_type' => 'Ordinateur',
        ]);

        // Vérifie que la réponse est une interdiction (403)
        $response->assertStatus(403);  // Force l'assertion à vérifier le code 403
    }
}
