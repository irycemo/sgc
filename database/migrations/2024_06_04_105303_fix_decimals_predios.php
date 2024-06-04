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
        Schema::table('predios', function (Blueprint $table) {
            $table->unsignedDecimal('superficie_terreno', 10,4)->nullable()->change();
            $table->unsignedDecimal('superficie_construccion', 10,4)->nullable()->change();
            $table->unsignedDecimal('superficie_judicial', 10,4)->nullable()->change();
            $table->unsignedDecimal('superficie_notarial', 10,4)->nullable()->change();
            $table->unsignedDecimal('area_comun_terreno', 10,4)->nullable()->change();
            $table->unsignedDecimal('area_comun_construccion', 10,4)->nullable()->change();
            $table->unsignedDecimal('valor_terreno_comun', 10,4)->nullable()->change();
            $table->unsignedDecimal('valor_construccion_comun', 10,4)->nullable()->change();
            $table->unsignedDecimal('valor_total_terreno', 10,4)->nullable()->change();
            $table->unsignedDecimal('valor_total_construccion', 10,4)->nullable()->change();
            $table->unsignedDecimal('valor_catastral', 10,4)->nullable()->change();
        });

        Schema::table('terrenos', function (Blueprint $table) {
            $table->unsignedDecimal('superficie', 10,4)->change();
            $table->unsignedDecimal('demerito', 10,4)->nullable()->change();
            $table->unsignedDecimal('valor_demeritado', 10,4)->nullable()->change();
            $table->unsignedDecimal('valor_unitario', 10,4)->change();
            $table->unsignedDecimal('valor_terreno', 10,4)->change();
        });

        Schema::table('condominioconstruccions', function (Blueprint $table) {
            $table->unsignedDecimal('area_comun_construccion', 10, 4)->nullable()->change();
            $table->unsignedDecimal('indiviso_construccion', 10, 4)->nullable()->change();
            $table->unsignedDecimal('valor_clasificacion_construccion', 10, 4)->nullable()->change();
            $table->unsignedDecimal('valor_construccion_comun', 10, 4)->nullable()->change();
        });

        Schema::table('construccions', function (Blueprint $table) {
            $table->unsignedDecimal('superficie', 10,4)->change();
            $table->unsignedDecimal('valor_unitario', 10,4)->change();
            $table->unsignedDecimal('valor_construccion', 10,4)->change();
        });

        Schema::table('condominioterrenos', function (Blueprint $table) {
            $table->unsignedDecimal('area_terreno_comun', 10,4)->change();
            $table->unsignedDecimal('indiviso_terreno', 10,4)->change();
            $table->unsignedDecimal('valor_unitario', 10,4)->change();
            $table->unsignedDecimal('valor_terreno_comun', 10,4)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
