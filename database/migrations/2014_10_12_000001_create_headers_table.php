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
        Schema::create('headers', function (Blueprint $table) {
            $table->id();
            $table->string('cover')->nullable();
            $table->string('videoId')->nullable();
            $table->string('mediaType')->default('image');
            $table->boolean('caption')->default(true);
            $table->boolean('overlay')->default(true);
            $table->string('overlayColor')->default("#b51a00");
            $table->string('textColor')->default("#ffffff");
            $table->string('overlayOpacity')->default('100');
            $table->morphs('headerable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('headers');
    }
};
