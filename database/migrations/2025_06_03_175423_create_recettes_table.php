<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recettes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('ingredients');
            $table->text('steps');
            $table->string('image_path')->nullable();
            $table->integer('preparation_time')->nullable();
            $table->enum('type', ['petit-déjeuner', 'déjeuner', 'dîner'])->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recettes');
    }
};
