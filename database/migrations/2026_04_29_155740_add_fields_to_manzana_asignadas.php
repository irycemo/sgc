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
        Schema::table('manzana_asignadas', function (Blueprint $table) {
            $table->string('xutm')->nullable()->after('lat');
            $table->string('yutm')->nullable()->after('lat');
            $table->string('zutm')->nullable()->after('lat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manzana_asignadas', function (Blueprint $table) {
            //
        });
    }
};
