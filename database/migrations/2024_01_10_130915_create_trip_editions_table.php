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
        Schema::create('trip_editions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->string('code');
            $table->string('duration');
            $table->date('date_from');
            $table->date('date_to');
            $table->string('thumbnail')->nullable();
            $table->string('cover')->nullable();
            $table->longText('reiseinfos')->nullable();
            $table->longText('program')->nullable();
            $table->longText('accommodation')->nullable();
            $table->longText('agb')->nullable();
            $table->boolean('visible')->nullable();
            $table->boolean('soldOut')->nullable();
            $table->boolean('ladiesOnly')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_editions');
    }
};
