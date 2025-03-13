<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('adresse_livraison', 100)->nullable(false);

            /*$table->string('prenom', 70)->nullable(true);
            //$table->date('date_de_naissance')->nullable(true);
            //$table->string('adresse', 100)->nullable(false);
            //$table->string('cp', 15)->nullable(false);
            //$table->string('ville', 70)->nullable(false);
            //$table->string('pays', 3)->nullable(false)->default('FRA');
            $table->string('adresse2', 100)->nullable(true);
            $table->string('cp2', 15)->nullable(true);
            $table->string('ville2', 70)->nullable(true);
            $table->string('pays2', 3)->nullable(true)->default('FRA');
            $table->enum('sexe', ['Femme', 'Homme', 'Autre'])->nullable(true);
            $table->string('telephone', 20)->nullable(true);
            */

            $table->rememberToken();

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
