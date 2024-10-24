<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade'); 
            $table->text('contenu'); 
            $table->integer('note'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('avis');
    }

    /**
     * Reverse the migrations.
     */
};
