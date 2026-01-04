<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedDate extends Model
{
    protected $table = 'blocked_dates';

    protected $fillable = [
        'property_id',
        'blocked_date',
    ];

    protected $casts = [
        'blocked_date' => 'date',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
