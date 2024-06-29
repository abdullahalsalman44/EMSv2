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
        Schema::create('salon_event_foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_id')->constrained('food');
            $table->foreignId('salon_event_id')->constrained('salon_events');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salon_event_foods');
    }
};
