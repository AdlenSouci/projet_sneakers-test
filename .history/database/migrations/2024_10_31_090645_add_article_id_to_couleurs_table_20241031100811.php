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
        Schema::create('couleurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom_couleur');
            $table->unsignedBigInteger('article_id'); // Ajout de l'article_id
            $table->timestamps();

            $table->index('nom_couleur')->unique();
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade'); // Définir la clé étrangère
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('couleurs', function (Blueprint $table) {
            $table->dropForeign(['article_id']); // Supprimer la clé étrangère
        });
        
        Schema::dropIfExists('couleurs');
    }
};
