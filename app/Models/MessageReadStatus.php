<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageReadStatus extends Model
{
    protected $table = 'message_read_status';

    protected $fillable = ['message_id', 'user_id', 'is_read', 'read_at'];


    //the 'read' flag belongs to a message
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }


    //the 'read' flag also belongs to the user duh cuz who else would read it? optimus prime?
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}