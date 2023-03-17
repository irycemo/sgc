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
        Schema::create('predios', function (Blueprint $table) {
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
            $table->string('tipo_vialidad');
            $table->string('tipo_asentamiento');
            $table->string('nombre_vialidad');
            $table->string('numero_exterior');
            $table->string('numero_exterior_2');
            $table->string('numero_adicional');
            $table->string('numero_adicional_2');
            $table->string('numero_interior');
            $table->string('nombre_asentamiento');
            $table->string('codigo_postal');
            $table->string('lote_fraccionador');
            $table->string('manzana_fraccionador');
            $table->string('etapa_fraccionador');
            $table->text('nombre_predio');
            $table->string('uso_1');
            $table->string('uso_2');
            $table->string('uso_3');
            $table->string('ubicacion_en_manzana');
            $table->unsignedDecimal('superficie_terreno', 18,2);
            $table->unsignedDecimal('superficie_construccion', 18,2);
            $table->unsignedDecimal('superficie_notarial', 18,2);
            $table->unsignedDecimal('valor_catastral', 18,2);
            $table->string('titulo_propiedad');
            $table->date('fecha_efectos');
            $table->string('curt')->nullable();
            $table->string('folio_real')->nullable();
            $table->string('estado')->default('activo');
            $table->unsignedDecimal('xutm')->nullable();
            $table->unsignedDecimal('yutm')->nullable();
            $table->unsignedInteger('zutm')->nullable();
            $table->unsignedDecimal('long')->nullable();
            $table->unsignedDecimal('lat')->nullable();
            $table->text('observaciones');
            $table->unsignedDecimal('valor_total_terreno', 18,2);
            $table->unsignedDecimal('valor_construccion', 18,2);
            $table->foreignId('actualizado_por')->nullable()->constrained()->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predios');
    }
};
