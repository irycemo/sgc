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
        Schema::create('cartografias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oficina_id')->constrained();
            $table->unsignedInteger('sector');
            $table->unsignedInteger('manzana')->nullable();
            $table->string('url');
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->unique(['oficina_id', 'sector', 'manzana'], 'cartografia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartografias');
    }
};
