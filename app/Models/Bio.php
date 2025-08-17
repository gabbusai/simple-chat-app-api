<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bio extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'profile_picture',
        'conversation_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
