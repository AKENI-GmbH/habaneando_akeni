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
        // Drop the 'iban' column if it exists
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('iban');
        });

        // Modify the address-related fields to be nullable
        Schema::table('customers', function (Blueprint $table) {
            $table->string('address')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('zip')->nullable()->change();
            $table->string('address_aux')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
};
