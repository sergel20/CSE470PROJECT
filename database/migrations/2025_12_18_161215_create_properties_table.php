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
        Schema::create('properties', function (Blueprint $table) {
            $table->id(); // id - AUTO_INCREMENT
            $table->unsignedInteger('host_id'); // host_id
            $table->string('title', 150); // title
            $table->text('description')->nullable(); // description
            $table->decimal('price', 10, 2); // price
            $table->decimal('rating', 3, 2)->nullable()->default(0.00); // rating
            $table->boolean('featured')->nullable()->default(0); // featured
            $table->string('photo', 255)->nullable(); // photo
            $table->timestamp('created_at')->useCurrent(); // created_at
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
