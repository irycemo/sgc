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
        Schema::create('tramite_administrativos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('localidad');
            $table->unsignedInteger('oficina');
            $table->unsignedInteger('tipo_predio');
            $table->unsignedInteger('numero_registro');
            $table->string('tipo');
            $table->unsignedInteger('año');
            $table->unsignedInteger('folio');
            $table->string('estado');
            $table->string('promovente')->nulalble();
            $table->string('finado')->nulalble();
            $table->string('archivo')->nullable();
            $table->foreignId('tramite_id')->constrained();
            $table->foreignId('oficina_id')->constrained();
            $table->foreignId('valuador')->nullable()->references('id')->on('users');
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->index(['localidad', 'oficina', 'tipo_predio', 'numero_registro'], 'cuenta_predial');

            $table->index(['año', 'folio']);

            $table->index('tipo');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramite_administrativos');
    }
};
