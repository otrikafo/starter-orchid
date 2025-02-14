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
        Schema::create('contacts', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID comme clé primaire
            $table->uuid('bien_id')->index(); // Clé étrangère, indexée
            $table->uuid('visiteur_id')->index(); // Clé étrangère, indexée
            $table->uuid('agence_id')->index()->nullable(); // Clé étrangère, indexée, nullable
            $table->text('message');
            $table->timestamps();

            $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade'); // Clé étrangère et suppression en cascade
            $table->foreign('visiteur_id')->references('id')->on('visiteurs')->onDelete('cascade'); // Clé étrangère et suppression en cascade
            $table->foreign('agence_id')->references('id')->on('agences')->onDelete('set null'); // Clé étrangère et suppression en cascade
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
