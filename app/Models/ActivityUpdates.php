<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityUpdates extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'status',
        'remarks',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activities::class);
    }
}
