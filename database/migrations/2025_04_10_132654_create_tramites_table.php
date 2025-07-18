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
            $table->string("tipo_servicio");
            $table->unsignedInteger("año");
            $table->unsignedInteger('folio');
            $table->unsignedInteger("usuario");
            $table->string('solicitante');
            $table->string('nombre_solicitante');
            $table->date("fecha_entrega")->nullable();
            $table->date("fecha_pago")->nullable()->index();
            $table->date("fecha_vencimiento")->nullable();
            $table->string("folio_pago")->nullable();
            $table->string('orden_de_pago')->nullable();
            $table->string('linea_de_captura')->nullable();
            $table->string('documento_de_pago')->nullable();
            $table->date("limite_de_pago")->nullable();
            $table->decimal("monto", 18, 2);
            $table->unsignedInteger('cantidad')->default(1);
            $table->unsignedInteger('usados')->default(0);
            $table->string("numero_oficio")->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('servicio_id')->constrained();
            $table->foreignId('ligado_a')->nullable()->references('id')->on('tramites');
            $table->unsignedInteger('avaluo_para')->nullable();
            $table->foreignId('adiciona')->nullable()->references('id')->on('tramites');
            $table->foreignId('predio_avaluo')->nullable()->references('id')->on('predio_avaluos');
            $table->unsignedInteger('usuario_tramites_linea_id')->nullable()->index();
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->unique(['año', 'folio', 'usuario']);

            $table->index('estado');

            $table->index('linea_de_captura');

            $table->index('created_at');

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
