<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('blocked_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listing_id');
            $table->date('blocked_date');
            $table->timestamps();

            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            $table->unique(['listing_id', 'blocked_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('blocked_dates');
    }
};
