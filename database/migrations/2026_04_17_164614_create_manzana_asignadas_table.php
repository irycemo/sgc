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
        Schema::create('manzana_asignadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('municipio');
            $table->unsignedInteger('zona');
            $table->unsignedInteger('localidad');
            $table->unsignedInteger('sector');
            $table->unsignedInteger('manzana');
            $table->string('lon')->nullable();
            $table->string('lat')->nullable();
            $table->foreignId('asignado_a')->nullable()->references('id')->on('users');
            $table->text('observaciones')->nullable();
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->index(['municipio', 'zona', 'localidad', 'sector', 'manzana'], 'manzana_asignada');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manzana_asignadas');
    }
};
