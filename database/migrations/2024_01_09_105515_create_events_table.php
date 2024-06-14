<?php

use App\Enum\EventTypeEnum;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->date('date_from');
            $table->date('date_to');
            $table->time('time_from');
            $table->time('time_to');
            $table->foreignId('ticket_type_id')->nullable()->constrained()->nullOnDelete();
            $table->longText('description');
            $table->longText('short_text')->nullable();
            $table->boolean('visible')->nullable();
            $table->boolean('bookable')->nullable();
            $table->boolean('onlyDoor')->nullable();
            $table->boolean('soldOut')->nullable();
            $table->boolean('ladiesOnly')->nullable();
            $table->boolean('status')->default(0);
            $table->string('event_type')->default(EventTypeEnum::PARTY);

            $table->string('thumbnail')->nullable();

            // $table->string('cover')->nullable();
            // $table->string('videoId')->nullable();
            // $table->boolean('headerType')->default(false);
            // $table->string('overlayColor')->default("#b51a00");
            // $table->boolean('overlay')->default(true);
            // $table->string('overlayOpacity')->default('100');

            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
