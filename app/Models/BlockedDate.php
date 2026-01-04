<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedDate extends Model
{
    protected $table = 'blocked_dates';

    protected $fillable = [
        'listing_id',
        'blocked_date',
    ];

    protected $casts = [
        'blocked_date' => 'date',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
