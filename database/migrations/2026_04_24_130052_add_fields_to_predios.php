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
        Schema::table('predios', function (Blueprint $table) {
            $table->text('domicilio_notificacion')->nullable()->after('declarante');
            $table->date('fecha_ultimo_avaluo')->nullable()->after('declarante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('predios', function (Blueprint $table) {
            //
        });
    }
};
