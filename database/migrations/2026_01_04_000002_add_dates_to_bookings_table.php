<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Add after host_id if property_id doesn't exist
            if (Schema::hasColumn('bookings', 'property_id')) {
                $table->date('start_date')->nullable()->after('property_id');
            } else {
                $table->date('start_date')->nullable()->after('host_id');
            }
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
        });
    }
};
