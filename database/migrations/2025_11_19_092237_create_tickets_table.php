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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('schedule_id')->constrained('bus_schedules')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable(); // optional: link to users table
            $table->string('passenger_name');
            $table->string('passenger_phone')->nullable();
            $table->integer('seat_no')->unsigned();
            $table->decimal('fare', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('total_amount', 12, 2)->default(0.00);

            $table->string('booking_reference')->unique();
            $table->enum('booking_status', ['confirmed','pending','cancelled','refunded'])->default('confirmed');
            $table->enum('payment_status', ['paid','unpaid','failed'])->default('unpaid');

            $table->json('meta')->nullable(); // store extras like passenger dob, gender etc.
            $table->timestamps();

            // prevent double booking same seat for same schedule at DB level
            $table->unique(['schedule_id', 'seat_no'], 'schedule_seat_unique');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
