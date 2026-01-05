<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Review.php
class Review extends Model
{
    protected $fillable = ['user_id', 'listing_id', 'rating', 'comment'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function guest() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function listing() {
        return $this->belongsTo(Listing::class);
    }
}
