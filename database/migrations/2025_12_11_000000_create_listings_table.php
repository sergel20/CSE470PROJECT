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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('country');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('property_type'); // apartment, house, villa, condo, etc.
            $table->integer('guest_capacity');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->decimal('price_per_night', 10, 2);
            $table->json('amenities')->nullable(); // JSON array of amenities
            $table->string('main_image')->nullable();
            $table->json('images')->nullable(); // JSON array of image paths
            $table->enum('status', ['draft', 'published', 'inactive'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
