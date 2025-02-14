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
        Schema::create('images_secondaires', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('bien_id')->index(); // Clé étrangère, indexée
            $table->uuid('fichier_id')->index(); // Clé étrangère, indexée
            $table->timestamps();

            $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade'); // Clé étrangère et suppression en cascade
            $table->foreign('fichier_id')->references('id')->on('fichiers')->onDelete('cascade'); // Clé étrangère et suppression en cascade
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images_secondaires');
    }
};
