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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id');
            $table->unsignedBigInteger('host_id');
            $table->unsignedBigInteger('property_id');
            $table->string('status')->default('pending');
            $table->integer('nights')->nullable();
            $table->decimal('nightly_rate', 10, 2)->nullable();
            $table->decimal('service_fee', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('guest_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('host_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};