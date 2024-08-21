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
        Schema::create('condominioconstruccions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('condominioconstruccionable_id');
            $table->string('condominioconstruccionable_type');
            $table->unsignedDecimal('area_comun_construccion', 10, 2)->nullable();
            $table->unsignedDecimal('indiviso_construccion', 10, 2)->nullable();
            $table->unsignedDecimal('valor_clasificacion_construccion', 10, 2)->nullable();
            $table->unsignedDecimal('valor_construccion_comun', 10, 2)->nullable();
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->index(['condominioconstruccionable_id', 'condominioconstruccionable_type'], 'morph_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condominioconstruccions');
    }
};
