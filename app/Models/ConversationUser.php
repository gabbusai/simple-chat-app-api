<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ConversationUser extends Pivot
{
    protected $table = 'conversation_user';
}
