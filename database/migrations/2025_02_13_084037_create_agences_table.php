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
        Schema::create('agences', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID comme clé primaire
            $table->string('raison_sociale');
            $table->string('siege');
            $table->string('nif')->unique();
            $table->string('stat')->unique();
            $table->string('email')->unique()->index();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_validated')->default(false)->index();
            $table->timestamp('validated_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agences');
    }
};
