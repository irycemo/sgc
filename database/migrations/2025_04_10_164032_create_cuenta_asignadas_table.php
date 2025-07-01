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
        Schema::create('cuenta_asignadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('localidad');
            $table->unsignedInteger('oficina');
            $table->unsignedInteger('tipo_predio');
            $table->unsignedInteger('numero_registro');
            $table->text('observaciones');
            $table->string('predio_origen')->nullable();
            $table->string('oficio')->nullable();
            $table->string('tipo_titulo')->nullable();
            $table->string('titulo_propiedad')->nullable();
            $table->boolean('estatus')->default(0);
            $table->foreignId('asignado_a')->nullable()->references('id')->on('users');
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->index(['documento_entrada', 'documento_numero']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuenta_asignadas');
    }
};
