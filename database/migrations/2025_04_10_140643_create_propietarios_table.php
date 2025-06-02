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
            $table->string('tipo')->nullable();
            $table->foreignId('persona_id')->constrained();
            $table->decimal('porcentaje_propiedad', 15,4)->nullable();
            $table->decimal('porcentaje_nuda', 15,4)->nullable();
            $table->decimal('porcentaje_usufructo', 15,4)->nullable();
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
