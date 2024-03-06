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
        Schema::create('course_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('cover')->nullable();
            $table->string('videoId')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('featured')->default(false);
            $table->boolean('contentType')->default(false);
            $table->boolean('caption')->default(1);
            $table->boolean('overlay')->default(true);
            $table->string('overlayColor')->default("#b51a00");
            $table->string('overlayOpacity')->default('100');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_categories');
    }
};
