<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('bus_bookings', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('bus_id');  
        $table->unsignedBigInteger('user_id')->nullable(); // optional

        $table->string('passenger_name');
        $table->string('passenger_mobile');
        $table->integer('passenger_count')->default(1);

        $table->decimal('price_per_ticket', 10, 2);
        $table->decimal('total_amount', 10, 2);

        $table->string('booking_status')->default('confirmed');  
        // confirmed, cancelled, refunded

        $table->string('payment_status')->default('unpaid');
        // paid, unpaid, failed

        $table->timestamps();

        $table->foreign('bus_id')->references('id')->on('buses')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_bookings');
    }
};
