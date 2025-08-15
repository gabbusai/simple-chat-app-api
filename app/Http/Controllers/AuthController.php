<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //use sanctum boi
    //$user = User::find(Auth::user()->id); nice little helper might use later lol
    public function register(RegisterRequest $request){
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);


        $token = $user->createToken($request->name);


        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
        ]);
    }

    public function login(LoginRequest $request){
        //find user
        $user = User::where('email', $request['email'])->first();

        if(!$user){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if(!Hash::check($request->password, $user->password)){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }


        $token = $user->createToken($user->name);


        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
        ]);
    }

    public function test(){
        return response()->json(['message' => 'Test successful']);
    }

    public function logout(Request $request)
    {
        //$user = User::find(Auth::user()->id);
        //return $user;
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
