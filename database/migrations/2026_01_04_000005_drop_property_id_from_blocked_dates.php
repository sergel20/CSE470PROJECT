<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the unique constraint first
        try {
            DB::statement('ALTER TABLE blocked_dates DROP INDEX blocked_dates_property_id_blocked_date_unique');
        } catch (\Exception $e) {
            // Constraint doesn't exist, continue
        }
        
        Schema::table('blocked_dates', function (Blueprint $table) {
            // Drop the column if it exists
            if (Schema::hasColumn('blocked_dates', 'property_id')) {
                $table->dropColumn('property_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blocked_dates', function (Blueprint $table) {
            $table->unsignedBigInteger('property_id')->nullable();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }
};
