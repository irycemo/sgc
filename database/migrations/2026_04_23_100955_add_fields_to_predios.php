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
            $table->string('regimen')->nullable()->after('declarante');
            $table->string('tomo')->nullable()->after('declarante');
            $table->string('registro')->nullable()->after('declarante');
            $table->string('libro')->nullable()->after('declarante');
            $table->integer('distrito')->nullable()->after('declarante');
            $table->date('fecha_otorgamiento')->nullable()->after('declarante');
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
