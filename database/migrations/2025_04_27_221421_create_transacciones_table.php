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
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('llc_id')->constrained('llc')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->string('stripe_session_id')->nullable();
            $table->string('stripe_payment_id')->nullable();
            $table->decimal('monto', 10, 2);
            $table->string('moneda', 3)->default('USD');
            $table->enum('estado', ['pendiente', 'procesando', 'completado', 'fallido', 'reembolsado'])->default('pendiente');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacciones');
    }
};
