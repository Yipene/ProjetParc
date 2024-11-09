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
        Schema::create('restitutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dotation_id'); // Référence à la dotation
            $table->date('date_restitution')->default(now()); // Date de la restitution
            $table->text('motif');
            $table->string('condition_equipement'); // État de l'équipement après restitution
            $table->text('commentaires')->nullable(); // Observations
            $table->timestamps();

            $table->foreign('dotation_id')->references('id')->on('dotations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restitutions');
    }
};
