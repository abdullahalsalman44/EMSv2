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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('salon_id')->constrained('salons')->cascadeOnDelete();
            $table->foreignId('reservation_id')->constrained('reservations');
            $table->enum('reson', ['Cancellation of reservation for an unknown reason
', 'Poor behavior of the staff in the hall
', 'Requesting additional fees inside the hall
', 'Manipulating the end date of the ceremony
', 'other reasons
']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
