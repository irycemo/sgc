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
        Schema::table('avaluos', function (Blueprint $table) {
            $table->foreignId('predio_ignorado_id')->after('notificado_en')->nullable()->references('id')->on('predio_ignorados');
            $table->foreignId('variacion_catastral_id')->after('notificado_en')->nullable()->references('id')->on('variacion_catastrals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('avaluos', function (Blueprint $table) {
            //
        });
    }
};
