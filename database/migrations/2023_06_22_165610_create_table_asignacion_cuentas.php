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
        Schema::create('asignacion_cuentas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('localidad');
            $table->unsignedInteger('oficina');
            $table->unsignedInteger('tipo_predio');
            $table->unsignedInteger('numero_registro');
            $table->text('observaciones');
            $table->string('predio_origen')->nullable();
            $table->string('titulo_propiedad')->nullable();
            $table->boolean('estatus')->default(0);
            $table->foreignId('valuador')->nullable()->references('id')->on('users');
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->index(['titulo_propiedad']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_asignacion_cuentas');
    }

};
