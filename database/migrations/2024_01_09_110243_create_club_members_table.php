<?php

use App\Enum\ClubMemberStatusEnum;
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
        Schema::create('club_members', function (Blueprint $table) {
            $table->id();
            $table->string('membership_id');
            $table->foreignId('customer_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('club_rate_id')->constrained()->onDelete('cascade');
            $table->string('status')->default(ClubMemberStatusEnum::ACTIVE);
            $table->string('valid_date_until')->nullable();
            $table->decimal('amount', 8, 2);
            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_members');
    }
};
