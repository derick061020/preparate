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
        Schema::create('llc', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('state');
            $table->string('business_type');
            $table->text('business_description');
            $table->string('street_address');
            $table->string('city');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('llc');
    }
};
