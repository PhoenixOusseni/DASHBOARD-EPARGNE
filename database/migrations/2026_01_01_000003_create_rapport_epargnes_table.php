<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapport_epargnes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('mois'); // 1-12
            $table->year('annee');
            $table->bigInteger('montant_warehouse')->default(0);
            $table->bigInteger('montant_cahier')->default(0);
            $table->bigInteger('montant_caisse')->default(0);
            $table->integer('rapports_g50')->default(0);
            $table->timestamps();

            // Un seul rapport par province par mois/année
            $table->unique(['province_id', 'mois', 'annee']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapport_epargnes');
    }
};
