<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->nullable();
            $table->string('name');
            $table->string('prenom')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telephone')->nullable();
            $table->string('photo')->nullable();
            $table->string('adresse')->nullable();
            $table->enum('role', ['admin', 'gestionnaire', 'technicien']);
            $table->enum('statut', ['actif', 'inactif']);
            $table->timestamp('last_login_at')->nullable(); // Nouvelle colonne pour la dernière connexion
            $table->timestamp('last_logout_at')->nullable(); // Nouvelle colonne pour la dernière déconnexion
            $table->rememberToken();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
