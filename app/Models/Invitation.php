<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['user_id', 'sender_id', 'conversation_id', 'status'];

    // Receiver of the invitation
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Sender of the invitation
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // The conversation the invite is for
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
