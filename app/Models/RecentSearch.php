<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location',
        'check_in',
        'check_out',
        'guests',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
