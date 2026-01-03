<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'guest_id', 'host_id', 'property_id', 'status', 'nights', 'nightly_rate', 'service_fee', 'total_price'
    ];

    public function guest()
    {
        return $this->belongsTo(User::class, 'guest_id');
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
