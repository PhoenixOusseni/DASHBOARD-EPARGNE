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
        Schema::create('montant_o_d_k_s', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('mois'); // 1-12
            $table->year('annee');
            $table->bigInteger('montant_odk')->default(0);
            $table->timestamps();

            $table->unique(['mois', 'annee']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('montant_o_d_k_s');
    }
};
