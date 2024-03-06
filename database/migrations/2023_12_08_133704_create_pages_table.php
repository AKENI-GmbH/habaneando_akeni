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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->string('name');
            $table->string('slug');
            $table->string('hero')->nullable();
            $table->string('videoId')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('headerType')->default(false);
            $table->boolean('caption')->default(false);
            $table->string('overlayColor')->default("#b51a00");
            $table->boolean('overlay')->default(true);
            $table->string('overlayOpacity')->default('100');
            $table->boolean('canDelete')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
