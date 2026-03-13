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
        Schema::create('terrenos_comuns', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('terrenos_comunsable_id');
            $table->string('terrenos_comunsable_type');
            $table->decimal('area_terreno_comun', 15,4);
            $table->decimal('indiviso_terreno', 15,4);
            $table->decimal('valor_unitario', 15,4);
            $table->decimal('superficie_proporcional', 15,4)->nullable();
            $table->decimal('valor_terreno_comun', 15,4);
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->index(['terrenos_comunsable_id', 'terrenos_comunsable_type'], 'morph_index');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terrenos_comuns');
    }
};
