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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipement_id')->constrained('equipements')->onDelete('cascade');
            $table->foreignId('technicien_id')->constrained('techniciens')->onDelete('cascade');
            $table->timestamp('date_reparation')->useCurrent();
            $table->text('panne');
            $table->text('action_reparation')->nullable();
            $table->date('date_fin_reparation')->nullable();
            $table->text('observations')->nullable();
            $table->string('statut')->default('En cours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
