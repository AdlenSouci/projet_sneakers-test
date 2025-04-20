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
        Schema::create('commandes_entetes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date')->nullable(false);
            $table->unsignedBigInteger('id_user')->nullable(false);
            $table->string('telephone')->nullable();
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('adresse_livraison')->nullable();

            $table->unsignedBigInteger('id_num_commande')->nullable(false);
            $table->decimal('total_ht')->default(0);
            $table->decimal('total_ttc')->default(0);
            $table->decimal('total_tva')->default(0);
            $table->decimal('total_remise')->default(0);


            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->index('date');
            $table->unique('id_num_commande');

            $table->foreign('id_user')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes_entetes');
    }
};
