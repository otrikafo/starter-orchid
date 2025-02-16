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
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID pour l'ID de la salle
            $table->foreignUuid('visiteur_id')->constrained('visiteurs')->cascadeOnDelete(); // Clé étrangère vers visiteurs
            $table->foreignUuid('agence_id')->constrained('agences')->cascadeOnDelete(); // Clé étrangère vers agences
            $table->timestamps();

            $table->unique(['visiteur_id', 'agence_id']); // Empêcher les salles doubles entre les mêmes visiteurs et agences
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
