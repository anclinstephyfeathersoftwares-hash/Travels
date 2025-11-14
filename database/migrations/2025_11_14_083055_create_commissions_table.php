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
    Schema::create('commissions', function (Blueprint $table) {
        $table->id();
        $table->string('receiver');
        $table->string('type')->default('Commission');
        $table->enum('status', ['Done', 'Pending'])->default('Pending');
        $table->date('date');
        $table->decimal('amount', 10, 2);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
