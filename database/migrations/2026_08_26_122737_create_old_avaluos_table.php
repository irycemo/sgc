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
        Schema::create('old_avaluos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('año')->nullable();
            $table->unsignedInteger('folio')->nullable();
            $table->unsignedInteger('usuario')->nullable();
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
            $table->string('uso_1')->nullable();
            $table->string('uso_2')->nullable();
            $table->string('uso_3')->nullable();
            $table->string('ubicacion_en_manzana')->nullable();
            $table->decimal('superficie_total_terreno', 15,4)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_avaluos');
    }
};
