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
        Schema::create('dress_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dress_id')->constrained('dresses');
            $table->integer('number');
            $table->foreignId('reservation_id')->constrained('reservations')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dress_reservations');
    }
};
