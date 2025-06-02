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
        Schema::create('construccions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('construccionable_id');
            $table->string('construccionable_type');
            $table->string('referencia');
            $table->string('tipo');
            $table->string('uso');
            $table->string('estado');
            $table->string('calidad');
            $table->unsignedInteger('niveles');
            $table->decimal('superficie', 15,4);
            $table->decimal('valor_unitario', 15,4);
            $table->decimal('valor_construccion', 15,4);
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->index(['construccionable_id', 'construccionable_type'], 'morph_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construccions');
    }
};
