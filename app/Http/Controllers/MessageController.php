<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //store
    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id'       => $user->id(),
            'message'         => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
