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
        Schema::table('llc', function (Blueprint $table) {
            $table->enum('estado', ['pendiente', 'completado', 'en_proceso', 'cancelado'])->default('pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('llc', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
