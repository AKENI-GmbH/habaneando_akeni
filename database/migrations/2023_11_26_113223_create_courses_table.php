<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('google_event_id')->nullable();
            $table->string('course_id');
            $table->string('name');
            $table->string('slug');

            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained('course_subcategories')->onDelete('cascade');
            $table->foreignId('teacher1_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('teacher2_id')->nullable()->constrained('teachers')->onDelete('cascade');

            $table->string('schedule_day')->nullable();
            $table->string('schedule_time_from')->nullable();
            $table->string('schedule_time_to')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('showMessage')->nullable();
            $table->string('messageTitle')->nullable();
            $table->longText('messageDescription')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('bookable')->nullable();
            $table->boolean('endless')->nullable();
            $table->boolean('allowClub')->nullable();
            $table->boolean('allowsinglePayment')->nullable();
            $table->boolean('soldout')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
