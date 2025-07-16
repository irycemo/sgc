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
        Schema::create('old_traslados', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('locl')->nullable();
            $table->unsignedInteger('ofna')->nullable();
            $table->unsignedInteger('tpre')->nullable();
            $table->unsignedInteger('nreg')->nullable();
            $table->unsignedInteger('anit')->nullable();
            $table->unsignedInteger('cont')->nullable();
            $table->unsignedInteger('cnot')->nullable();
            $table->string('stat')->nullable();
            $table->text('act1')->nullable();
            $table->text('nven')->nullable();
            $table->text('adquiriente')->nullable();
            $table->date('ffir')->nullable();
            $table->timestamps();

            $table->index(['locl', 'ofna', 'tpre', 'nreg'], 'cuenta_predial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_traslados');
    }
};
