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
        Schema::create('construcciones_comuns', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('construcciones_comunsable_id');
            $table->string('construcciones_comunsable_type');
            $table->decimal('area_comun_construccion', 15,4)->nullable();
            $table->decimal('superficie_proporcional', 15,4)->nullable();
            $table->decimal('indiviso_construccion', 15,4)->nullable();
            $table->decimal('valor_clasificacion_construccion', 15,4)->nullable();
            $table->decimal('valor_construccion_comun', 15,4)->nullable();
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->index(['construcciones_comunsable_id', 'construcciones_comunsable_type'], 'morph_index');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construcciones_comuns');
    }
};
