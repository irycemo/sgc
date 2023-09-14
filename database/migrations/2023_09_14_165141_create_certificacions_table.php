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
        Schema::create('certificacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('predio_id');
            $table->unsignedInteger('numero_certificado');
            $table->text('cadena_originial');
            $table->text('cadena_encriptada');
            $table->string('documento');
            $table->string('estado');
            $table->unsignedInteger('oficina');
            $table->foreignId('creado_por')->references('id')->on('users');
            $table->string('actualizado_por');
            $table->foreignId('tramite_id');
            $table->text('observaciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificacions');
    }
};
