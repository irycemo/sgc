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
        Schema::create('historicos', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_actualizacion')->nullable();
            $table->timestamp('fecha_escritura')->nullable();
            $table->timestamp('fecha_movimiento')->nullable();
            $table->string('empleado')->nullable();
            $table->string('movimiento')->nullable();
            $table->string('adquiriente')->nullable();
            $table->string('transmitente')->nullable();
            $table->unsignedInteger('numero_registro_inicial')->nullable();
            $table->unsignedInteger('numero_registro_final')->nullable();
            $table->unsignedInteger('valor_catastral')->nullable();
            $table->unsignedInteger('numero_documento')->nullable();
            $table->unsignedInteger('numero_fojas')->nullable();
            $table->unsignedInteger('numero_tomo')->nullable();
            $table->unsignedInteger('capital_mayor_fojas')->nullable();
            $table->unsignedInteger('capital_mayor_tomo')->nullable();
            $table->unsignedInteger('numero_comprobante')->nullable();
            $table->decimal('superficie_notaria', 8,4)->nullable();
            $table->decimal('superficie_terreno', 8,4)->nullable();
            $table->decimal('superficie_construccion', 8,4)->nullable();
            $table->text('ubicacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historicos');
    }
};
