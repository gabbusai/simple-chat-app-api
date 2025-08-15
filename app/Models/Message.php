<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    protected $fillable = ['conversation_id', 'sender_id', 'content'];


    //messages belong to a conversation
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }


    //message also belongs to a user 
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    //if a message is in a GC it can be read by multiple people ofc
    public function readStatuses(): HasMany
    {
        return $this->hasMany(MessageReadStatus::class);
    }
}
