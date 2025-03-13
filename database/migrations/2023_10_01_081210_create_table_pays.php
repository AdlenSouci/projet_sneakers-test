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
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->string('numerique',3)->nullable(false); 
            $table->string('alpha2',2)->nullable(false);
            $table->string('alpha3',3)->nullable(false);
            $table->string('nom',60)->nullable(false);
            $table->string('nom_gb',60)->nullable(false);
            
            $table->index('numerique');
            $table->index('alpha2');
            $table->index('alpha3');
            $table->index('nom');            
            $table->index('nom_gb');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pays');
    }
};