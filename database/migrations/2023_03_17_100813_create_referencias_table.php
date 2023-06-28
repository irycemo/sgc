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
        Schema::create('referencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('referenciaable_id');
            $table->string('referenciaable_type');
            $table->string('referencia');
            $table->string('tipo');
            $table->string('uso');
            $table->string('estado');
            $table->string('calidad');
            $table->unsignedInteger('niveles');
            $table->unsignedDecimal('superficie', 15,2);
            $table->unsignedDecimal('valor_unitario', 15,2);
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referencias');
    }
};
