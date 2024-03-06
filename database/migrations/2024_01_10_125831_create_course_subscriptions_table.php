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
        Schema::create('course_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->boolean('student')->default(false);
            $table->integer('numberOfMen')->default(0);
            $table->integer('numberOfWomen')->default(0);
            $table->boolean('clubMember')->default(false);
            $table->string('subscriptionType');
            $table->decimal('amount', 8, 2);
            $table->decimal('fee', 5, 2)->nullable();
            $table->string('method');
            $table->string('payment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_subscriptions');
    }
};
