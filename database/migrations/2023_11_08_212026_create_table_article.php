<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_famille')->nullable(false);
            $table->unsignedBigInteger('id_marque')->nullable(false);
            $table->string('modele', 70)->nullable(false);
            $table->text('description')->nullable(true);
            $table->unsignedBigInteger('id_couleur')->nullable(false);
            $table->decimal('prix_public', 9, 2)->nullable(false);
            $table->decimal('prix_achat', 9, 2)->nullable(false);
            $table->string('img')->nullable(false);

            $table->timestamps();


            $table->index('modele');
            $table->index('prix_public');

            // Clés étrangères
            $table->foreign('id_marque')->references('id')->on('marques');
            $table->foreign('id_famille')->references('id')->on('familles');
            $table->foreign('id_couleur')->references('id')->on('couleurs');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
