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
        Schema::table('condominioconstruccions', function (Blueprint $table) {
            $table->unsignedDecimal('superficie_proporcional', 10, 2)->nullable()->after('indiviso_construccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('condominioconstruccions', function (Blueprint $table) {
            //
        });
    }
};
