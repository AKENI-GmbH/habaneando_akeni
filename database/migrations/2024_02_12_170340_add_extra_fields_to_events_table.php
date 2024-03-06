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
        Schema::table('events', function (Blueprint $table) {
            $table->mediumText('program')->after('conditions')->nullable();
            $table->longText('accomodation')->after('program')->nullable();
            $table->json('extras')->after('accomodation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('program');
            $table->dropColumn('accomodation');
            $table->dropColumn('extras');
        });
    }
};
