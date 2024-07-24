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
        Schema::create('variacion_catastrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('año');
            $table->unsignedInteger('folio')->nullable();
            $table->string('estado');
            $table->foreignId('tramite_id')->constrained();
            $table->string('promovente');
            $table->string('finado')->nullable();
            $table->string('archivo')->nullable();
            $table->foreignId('oficina_id')->constrained();
            $table->foreignId('valuador')->nullable()->references('id')->on('users');
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->unique(['año', 'folio']);

            $table->index('estado');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variacion_catastrals');
    }
};
