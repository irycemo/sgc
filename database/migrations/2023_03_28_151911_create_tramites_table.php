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
        Schema::create('tramites', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->string("tipo_tramite");
            $table->unsignedInteger("año");
            $table->unsignedInteger('folio');
            $table->unsignedInteger("usuario");
            $table->foreignId('servicio_id')->constrained();
            $table->string('solicitante');
            $table->string('nombre_solicitante');
            $table->unsignedDecimal("monto", 18, 2);
            $table->date("fecha_entrega")->nullable();
            $table->date("fecha_pago")->nullable();
            $table->date("fecha_vencimiento")->nullable();
            $table->string("folio_pago")->nullable();
            $table->string("tipo_servicio");
            $table->string('orden_de_pago')->nullable();
            $table->string('linea_de_captura')->nullable();
            $table->unsignedInteger('cantidad')->default(1);
            $table->unsignedInteger('usados')->default(0);
            $table->string("numero_oficio")->nullable();
            $table->foreignId('parcial_usado')->nullable()->references('id')->on('tramites');
            $table->foreignId('avaluo_para')->nullable()->references('id')->on('tramites');
            $table->foreignId('adiciona')->nullable()->references('id')->on('tramites');
            $table->text('observaciones')->nullable();
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->unique(['año', 'folio', 'usuario']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramites');
    }
};
