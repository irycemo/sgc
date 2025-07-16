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
        Schema::create('old_audits', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->nullable();
            $table->unsignedInteger('locl')->nullable();
            $table->unsignedInteger('ofna')->nullable();
            $table->unsignedInteger('tpre')->nullable();
            $table->unsignedInteger('nreg')->nullable();
            $table->date('fecha ')->nullable();
            $table->string('emple')->nullable();
            $table->string('expe')->nullable();
            $table->unsignedInteger('ania')->nullable();
            $table->unsignedInteger('foli')->nullable();
            $table->unsignedInteger('usua')->nullable();
            $table->timestamps();

            $table->index(['locl', 'ofna', 'tpre', 'nreg'], 'cuenta_predial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_audits');
    }
};
