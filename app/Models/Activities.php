<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'remarks',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activityUpdates()
    {
        return $this->hasMany(ActivityUpdates::class);
    }
}
