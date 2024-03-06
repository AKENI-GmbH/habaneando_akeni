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
        Schema::table('course_categories', function (Blueprint $table) {
            $table->dropColumn('cover');
            $table->dropColumn('videoId');
            $table->dropColumn('contentType');
            $table->dropColumn('caption');
            $table->dropColumn('overlayColor');
            $table->dropColumn('overlay');
            $table->dropColumn('overlayOpacity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_categories', function (Blueprint $table) {
            //
        });
    }
};
