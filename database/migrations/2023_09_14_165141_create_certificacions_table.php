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
            $table->unsignedInteger('año');
            $table->unsignedInteger('folio');
            $table->string('documento');
            $table->text('cadena_originial');
            $table->text('cadena_encriptada')->nullable();
            $table->string('estado');
            $table->foreignId('oficina_id');
            $table->foreignId('tramite_id')->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('creado_por')->references('id')->on('users');
            $table->foreignId('actualizado_por')->references('id')->on('users');
            $table->timestamps();

            $table->unique(['año', 'folio', 'documento']);

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
