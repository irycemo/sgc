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
        Schema::create('predio_tramite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tramite_id')->constrained();
            $table->foreignId('predio_id')->constrained();
            $table->string('estado')->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_predio_tramite');
    }
};
