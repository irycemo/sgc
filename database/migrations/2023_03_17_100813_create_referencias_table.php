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
            $table->foreignId('predio_id')->constrained();
            $table->string('tipo_construccion');
            $table->string('uso_construccion');
            $table->string('categoria_construccion');
            $table->string('calidad_construccion');
            $table->unsignedInteger('numero_niveles_construccion');
            $table->unsignedDecimal('superficie_construccion', 15,2);
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
