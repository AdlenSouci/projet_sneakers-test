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
            $table->timestamps();

            $table->index('nom_couleur')->unique();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couleurs');

    
    }
};
