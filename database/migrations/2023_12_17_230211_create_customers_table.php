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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->string('gender');
            $table->string('address');
            $table->string('city');
            $table->string('zip');
            $table->string('profession')->nullable();
            $table->string('iban')->nullable();
            $table->string('kontoinhaber')->nullable();
            $table->string('BIC')->nullable();
            $table->string('address_aux')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->date('birthday')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
