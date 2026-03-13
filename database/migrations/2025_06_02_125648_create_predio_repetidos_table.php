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
        Schema::create('predio_repetidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('estado');
            $table->unsignedInteger('region_catastral');
            $table->unsignedInteger('municipio');
            $table->unsignedInteger('zona_catastral');
            $table->unsignedInteger('localidad');
            $table->unsignedInteger('sector');
            $table->unsignedInteger('manzana');
            $table->unsignedInteger('predio');
            $table->unsignedInteger('edificio');
            $table->unsignedInteger('departamento');
            $table->unsignedInteger('oficina');
            $table->unsignedInteger('tipo_predio');
            $table->unsignedInteger('numero_registro');
            $table->text('error')->nullable();
            $table->unsignedInteger('count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predio_repetidos');
    }
};
