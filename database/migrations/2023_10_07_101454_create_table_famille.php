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
        Schema::create('familles', function (Blueprint $table) {
            $table->id();
            $table->string('nom_famille', 70)->nullable(false)->unique();
            $table->unsignedBigInteger('id_parent')->nullable(true);
            
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->index('nom_famille');
            $table->index('id_parent');
            $table->index('id_parent', 'nom')->unique();
            $table->foreign('id_parent')->references('id')->on('familles');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('familles');
    }
};
