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
        Schema::create('terrenos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('terrenoable_id');
            $table->string('terrenoable_type');
            $table->unsignedDecimal('superficie', 10, 2);
            $table->unsignedDecimal('demerito', 10, 2)->nullable();
            $table->unsignedDecimal('valor_demeritado', 10, 2)->nullable();
            $table->unsignedDecimal('valor_unitario', 10, 2);
            $table->unsignedDecimal('valor_terreno', 10, 2);
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->index(['terrenoable_id', 'terrenoable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terrenos');
    }
};
