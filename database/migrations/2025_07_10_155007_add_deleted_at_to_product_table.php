<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product', function (Blueprint $table) {
            // Esta línea agrega la columna `deleted_at`
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            // Esto permite revertir la migración si es necesario
            $table->dropSoftDeletes();
        });
    }
};