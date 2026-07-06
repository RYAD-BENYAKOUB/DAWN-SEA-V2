<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating')->comment('Note de 1 à 5 étoiles');
            $table->text('comment');
            $table->timestamps();

            // Un utilisateur ne peut laisser qu'un seul avis par programme
            $table->unique(['user_id', 'program_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
