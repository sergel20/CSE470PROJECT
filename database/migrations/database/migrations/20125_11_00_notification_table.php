<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            // Primary key uses UUID for notifications
            $table->uuid('id')->primary();

            // Notification class type (e.g., App\Notifications\BookingStatusNotification)
            $table->string('type');

            // Polymorphic relation: allows notifications to belong to any notifiable model (usually User)
            $table->morphs('notifiable'); // creates notifiable_id + notifiable_type

            // JSON payload with notification data
            $table->text('data');

            // Timestamp when notification was read
            $table->timestamp('read_at')->nullable();

            // Created_at and updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
