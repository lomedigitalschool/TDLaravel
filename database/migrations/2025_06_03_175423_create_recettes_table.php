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
        Schema::create('recettes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Lien avec l'utilisateur
            $table->string('title');
            $table->text('description');
            $table->text('ingredients'); // On stockera en texte brut ou JSON
            $table->text('steps'); // Idem
            $table->string('image_path')->nullable(); // Image facultative
            $table->integer('preparation_time')->nullable(); // en minutes
            $table->enum('type', ['petit-déjeuner', 'déjeuner', 'dîner'])->nullable();
            $table->tinyInteger('rating')->nullable(); // de 1 à 5
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recettes');
    }
};
