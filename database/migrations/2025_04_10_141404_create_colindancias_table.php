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
        Schema::create('colindancias', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('colindanciaable_id');
            $table->string('colindanciaable_type');
            $table->string('viento');
            $table->decimal('longitud', 15, 4);
            $table->text('descripcion');
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->index(['colindanciaable_id', 'colindanciaable_type'], 'morph_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colindancias');
    }
};
