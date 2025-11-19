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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('from');
            $table->string('to');
            $table->integer('distance_km')->unsigned()->nullable();
            $table->decimal('base_fare', 10, 2)->default(0.00);
            $table->json('meta')->nullable(); // optional JSON for extra route info
            $table->timestamps();

            $table->index(['from', 'to']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
