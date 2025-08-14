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
            $table->uuid('uuid');
            $table->unsignedInteger('tipo');
            $table->unsignedInteger('año');
            $table->unsignedInteger('folio');
            $table->mediumText('cadena_original');
            $table->text('cadena_encriptada')->nullable();
            $table->string('estado');
            $table->foreignId('oficina_id')->nullable()->references('id')->on('oficinas');
            $table->foreignId('tramite_id')->nullable()->references('id')->on('tramites');
            $table->foreignId('predio_id')->nullable()->references('id')->on('predios');
            $table->text('observaciones')->nullable();
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->unique(['tipo', 'año', 'folio']);

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
