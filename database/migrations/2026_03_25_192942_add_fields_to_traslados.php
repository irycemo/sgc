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
        Schema::table('traslados', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_aviso')->after('aviso_stl');
            $table->unsignedBigInteger('folio_aviso')->after('aviso_stl');
            $table->unsignedBigInteger('año_aviso')->after('aviso_stl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traslados', function (Blueprint $table) {
            //
        });
    }
};
