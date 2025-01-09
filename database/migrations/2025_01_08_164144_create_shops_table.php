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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('holder');
            $table->string('email');
            $table->string('bic');
            $table->string('iban');
            $table->string('bank');
            $table->string('bank_address');
            $table->string('phone', 25);
            $table->string('facebook');
            $table->text('home');
            $table->text('home_infos');
            $table->text('home_shipping');
            $table->boolean('invoice')->default(true);
            $table->boolean('card')->default(true);
            $table->boolean('transfer')->default(true);
            $table->boolean('check')->default(true);
            $table->boolean('mandat')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
