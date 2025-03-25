<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commandes_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_commande')->nullable(false);
            $table->unsignedBigInteger('id_article')->nullable(false);
            $table->integer('taille')->nullable(false);
            $table->integer('quantite')->nullable(false);
            $table->decimal('prix_ht', 9, 2)->nullable(false);
            $table->decimal('prix_ttc', 9, 2)->nullable(false);
            $table->decimal('montant_tva', 9, 2)->nullable(false);
            $table->decimal('remise', 9, 2)->nullable(true);

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));


            $table->index('id_commande');
            $table->index('id_article');

            $table->foreign('id_commande')->references('id')->on('commandes_entetes');
            $table->foreign('id_article')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes_details');
    }
};
