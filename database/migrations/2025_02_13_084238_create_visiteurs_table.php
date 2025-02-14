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
        Schema::create('visiteurs', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID comme clé primaire
            $table->string('email')->unique()->index();
            $table->string('password');
            // Nom
            $table->string('nom')->nullable();
            // Prénom
            $table->string('prenom')->nullable();
            // Adresse
            $table->string('adresse')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visiteurs');
    }
};
