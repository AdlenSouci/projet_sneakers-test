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
        Schema::table('couleurs', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id')->after('nom_couleur'); // Ajout de la colonne article_id

            // Définir la contrainte de clé étrangère
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('couleurs', function (Blueprint $table) {
            $table->dropForeign(['article_id']); // Supprimer la contrainte de clé étrangère
            $table->dropColumn('article_id'); // Supprimer la colonne
        });
    }
};
