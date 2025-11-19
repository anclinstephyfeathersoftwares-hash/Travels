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
        Schema::create('bus_schedules', function (Blueprint $table) {
            $table->id();

            // references
            $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade');
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');

            // schedule details
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->date('travel_date');

            // derived / convenience fields
            $table->string('duration')->nullable();
            $table->integer('seats_available')->unsigned()->nullable(); // can be calculated, stored for performance

            $table->timestamps();

            $table->unique(['bus_id', 'route_id', 'travel_date', 'departure_time'], 'bus_schedule_unique');
            $table->index('travel_date');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_schedules');
    }
};
