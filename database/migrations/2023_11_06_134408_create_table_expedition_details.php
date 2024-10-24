<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expedition_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_num_commande')->nullable(false);

            $table->unsignedBigInteger('id_num_bon_livraison')->nullable(false);
            $table->unsignedBigInteger('id_num_ligne_bon_livraison')->nullable(false);
            $table->unsignedBigInteger('id_article')->nullable(false);
            $table->string('adresse')->nullable(false);

            $table->integer('quantite_livraison')->nullable(false);
            $table->decimal('prix_ht', 9, 2)->nullable(false);
            $table->decimal('prix_ttc', 9, 2)->nullable(false);
            $table->decimal('montant_ht', 9, 2)->nullable(false);
            $table->decimal('remise', 9, 2)->nullable(false);
            
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));



            $table->index('id_num_commande');
            $table->index('montant_ht');
            $table->index('remise');


            $table->foreign('id_article')->references('id')->on('articles');
            $table->foreign('id_num_commande')->references('id')->on('commandes_entetes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedition_details');
    }
};
