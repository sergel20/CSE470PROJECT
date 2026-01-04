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
        // Update bookings table to add listing_id
        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                // Ensure listing_id exists with proper foreign key
                if (!Schema::hasColumn('bookings', 'listing_id')) {
                    $table->unsignedBigInteger('listing_id')->after('host_id')->nullable();
                    $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
                }
            });
        }

        // Update blocked_dates table to add listing_id
        if (Schema::hasTable('blocked_dates')) {
            Schema::table('blocked_dates', function (Blueprint $table) {
                // Ensure listing_id exists with proper foreign key
                if (!Schema::hasColumn('blocked_dates', 'listing_id')) {
                    $table->unsignedBigInteger('listing_id')->after('id')->nullable();
                    $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert changes if needed
        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                if (Schema::hasColumn('bookings', 'listing_id')) {
                    $table->dropForeign(['listing_id']);
                    $table->dropColumn('listing_id');
                }
                if (!Schema::hasColumn('bookings', 'property_id')) {
                    $table->unsignedBigInteger('property_id')->after('guest_id')->nullable();
                }
            });
        }

        if (Schema::hasTable('blocked_dates')) {
            Schema::table('blocked_dates', function (Blueprint $table) {
                if (Schema::hasColumn('blocked_dates', 'listing_id')) {
                    $table->dropForeign(['listing_id']);
                    $table->dropColumn('listing_id');
                }
                if (!Schema::hasColumn('blocked_dates', 'property_id')) {
                    $table->unsignedBigInteger('property_id')->after('id')->nullable();
                }
            });
        }
    }
};
