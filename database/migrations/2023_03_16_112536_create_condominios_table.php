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
        Schema::create('condominios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('predio_id')->constrained();
            $table->string('nombre_conjundo');
            $table->string('edificio');
            $table->string('numero_departamento');
            $table->unsignedDecimal('superficie_privativa_construida', 18,2);
            $table->unsignedDecimal('superficie_terreno_privativo', 18,2);
            $table->unsignedDecimal('indiviso_terreno', 18,2);
            $table->unsignedInteger('indice_construccion');
            $table->unsignedDecimal('superficie_proporcional_terreno', 18,2);
            $table->unsignedDecimal('superficie_proporcional_construuccion', 18,2);
            $table->foreignId('creado_por')->nullable()->constrained()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->constrained()->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condominios');
    }
};
