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
        Schema::create('umas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('año')->unique();
            $table->unsignedFloat('diario');
            $table->unsignedFloat('mensual');
            $table->unsignedFloat('anual');
            $table->unsignedFloat('minimo_rustico')->nullable();
            $table->unsignedFloat('minimo_urbano')->nullable();
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
        Schema::dropIfExists('umas');
    }
};
