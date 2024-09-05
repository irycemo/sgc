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
        Schema::create('propietarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('propietarioable_id');
            $table->string('propietarioable_type');
            $table->foreignId('persona_id')->constrained();
            $table->string('tipo');
            $table->unsignedDecimal('porcentaje', 15,2)->nullable();
            $table->unsignedDecimal('porcentaje_nuda', 15,2)->nullable();
            $table->unsignedDecimal('porcentaje_usufructo', 15,2)->nullable();
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->index(['propietarioable_id', 'propietarioable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propietarios');
    }
};
