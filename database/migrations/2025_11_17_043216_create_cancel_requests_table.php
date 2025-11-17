<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cancel_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_type')->default('Cancel Ticket');
            $table->string('pnr');
            $table->string('passenger_name');
            $table->string('ticket_number');
            $table->string('cancel_reason');
            $table->date('cancel_date');
            $table->string('flight_no');
            $table->text('remarks')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cancel_requests');
    }
};
