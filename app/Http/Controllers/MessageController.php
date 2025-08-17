<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\ConversationRequest;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //return user
    public function getUser()
    {
        return Auth::user();
    }
    //get user by id
    public function getUserById($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
        return $user;
    }
    //search for users
    public function searchUser(Request $request){
        //paginated
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');

        if(!$search) {
            return response()->json([
                'message' => 'Search query is required',
            ], 400);
        }

        if($search){
            $query = User::whereAny([
                'name',
                'email'
            ], 'like', "%$search%");
        }

        $users = $query->paginate($perPage);

        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'No users found',
            ], 404);
        }

        return response()->json([
            'users' => $users->items(),
            'pagination' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
                'next_page_url' => $users->nextPageUrl(),
                'prev_page_url' => $users->previousPageUrl()
            ]
        ]);
    }

    //return conversation
    public function getConversation($id)
    {
        return Conversation::find($id);
    }

    //add conversation
    public function createConversation(ConversationRequest $request){

        //user
        $user = User::find(Auth::user()->id);

        //create conversation
        $conversation = Conversation::create([
            'name' => $request->name,
            'is_group' => $request->is_group,
        ]);

        //add user to conversation
        $conversation->users()->attach($user);

        //add others to conversation
        if ($request->has('user_ids')) {
            $conversation->users()->attach($request->user_ids);
        }
    }
    //store message
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
