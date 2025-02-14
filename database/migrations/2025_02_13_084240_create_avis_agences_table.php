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
        Schema::create('avis_agences', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID comme clé primaire
            $table->uuid('agence_id')->index(); // Clé étrangère, indexée
            $table->uuid('visiteur_id')->index(); // Clé étrangère, indexée
            $table->integer('note');
            $table->text('commentaire')->nullable();
            $table->timestamps();

            $table->foreign('agence_id')->references('id')->on('agences')->onDelete('cascade'); // Clé étrangère et suppression en cascade
            $table->foreign('visiteur_id')->references('id')->on('visiteurs')->onDelete('cascade'); // Clé étrangère et suppression en cascade
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis_agences');
    }
};
