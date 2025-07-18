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
        Schema::create('requerimientos', function (Blueprint $table) {
            $table->id();
            $table->string('requerimientoable_id');
            $table->string('requerimientoable_type');
            $table->string('estado');
            $table->string('archivo_url')->nullable();
            $table->string('usuario_stl')->nullable();
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            $table->index(['requerimientoable_id', 'requerimientoable_type'], 'morph_index');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requerimientos');
    }
};
