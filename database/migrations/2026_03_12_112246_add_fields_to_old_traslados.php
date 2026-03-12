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
        Schema::table('old_traslados', function (Blueprint $table) {
            $table->string('nombre_predio')->nullable();
            $table->string('superficie_notarial')->nullable();
            $table->string('superficie_construccion')->nullable();
            $table->string('antecedente_tomo')->nullable();
            $table->string('antecedente_registro')->nullable();
            $table->string('antecedente_acto')->nullable();
            $table->string('documento_entrada')->nullable();
            $table->string('documento_numero')->nullable();
            $table->string('distrito')->nullable();
            $table->string('seccion')->nullable();
            $table->string('observacion')->nullable();
            $table->string('lugar_firma')->nullable();
            $table->string('fecha_firma')->nullable();
            $table->string('anexos')->nullable();
            $table->string('valor_base')->nullable();
            $table->string('reduccion')->nullable();
            $table->string('tasa')->nullable();
            $table->string('valor_avaluo')->nullable();
            $table->string('valor_vivienda_mixto')->nullable();
            $table->string('valor_otro_uso_mixto')->nullable();
            $table->string('isai')->nullable();
            $table->string('fecha_reduccion')->nullable();
            $table->string('valor_catastral')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->string('tramtie_año')->nullable();
            $table->string('tramtie_folio')->nullable();
            $table->string('tramtie_usuario')->nullable();
            $table->string('avaluo_año')->nullable();
            $table->string('avaluo_folio')->nullable();
            $table->string('avaluo_usuario')->nullable();
            $table->string('nombre_notario')->nullable();
            $table->string('certificado_año')->nullable();
            $table->string('certificado_folio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('old_traslados', function (Blueprint $table) {
            //
        });
    }
};
