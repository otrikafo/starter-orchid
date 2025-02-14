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
        Schema::create('biens', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID comme clé primaire
            $table->uuid('agence_id')->index(); // Clé étrangère, indexée
            $table->string('titre');
            $table->text('description');
            $table->decimal('prix', 10, 2);
            $table->string('adresse');
            $table->string('ville');
            $table->integer('superficie');
            $table->integer('nombre_pieces');
            $table->integer('nombre_chambres');
            $table->integer('nombre_salles_de_bain');
            $table->string('type_bien'); // Enum, validation dans le modèle
            $table->string('type_transaction'); // Enum, validation dans le modèle
            $table->string('image_principale')->nullable(); // Chemin vers l'image
            $table->timestamps();

            $table->foreign('agence_id')->references('id')->on('agences')->onDelete('cascade'); // Clé étrangère et suppression en cascade
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
