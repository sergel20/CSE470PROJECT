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
        // Check if column exists before trying to drop
        if (!Schema::hasColumn('bookings', 'property_id')) {
            return; // Column doesn't exist, nothing to do
        }
        
        Schema::table('bookings', function (Blueprint $table) {
            try {
                $table->dropForeign(['property_id']);
            } catch (\Exception $e) {
                // Foreign key doesn't exist, continue
            }
            
            $table->dropColumn('property_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('property_id')->nullable();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }
};
