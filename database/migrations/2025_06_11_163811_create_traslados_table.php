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
        Schema::create('traslados', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->string('tipo');
            $table->unsignedBigInteger('avaluo_spe')->nullable()->index();
            $table->unsignedBigInteger('aviso_stl')->index();
            $table->unsignedBigInteger('entidad_stl')->index();
            $table->string('entidad_nombre');
            $table->foreignId('predio_id')->constrained();
            $table->foreignId('certificacion_id')->nullable()->constrained();
            $table->foreignId('tramite_aviso')->references('id')->on('tramites');
            $table->foreignId('asignado_a')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traslados');
    }
};
