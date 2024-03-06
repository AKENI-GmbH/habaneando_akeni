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
        Schema::create('trip_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_edition_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_ticket_id')->constrained()->onDelete('cascade');
            $table->string('anrede');
            $table->string('name');
            $table->string('strasse');
            $table->string('plz_ort');
            $table->string('email');
            $table->string('telefon');
            $table->longText('bemerkung');
            $table->decimal('amount', 8, 2);
            $table->decimal('first_payment', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_subscriptions');
    }
};
