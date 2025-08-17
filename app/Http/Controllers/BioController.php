<?php

namespace App\Http\Controllers;

use App\Models\Bio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BioController extends Controller
{
    //get bio by id
    public function getBioById($id){
        $user = User::findOrFail($id);
        $bio = $user->bio;
        $bio->load('user:id,name,email');
        if (!$bio) {
            return response()->json(['message' => 'Bio not found'], 404);
        }
        return response()->json($bio);
    }


    //update bio
public function updateBio(Request $request)
{
    $request->validate([
        'bio' => 'nullable|string|max:500',
        'profile_picture' => 'nullable|image|max:2048', // 2MB
    ]);

    $bio = $request->user()->bio;

    if($request->hasFile('profile_picture')) {

        //delete old if it exists
        if($bio->profile_picture && Storage::disk('public')->exists($bio->profile_picture)) {
            Storage::disk('public')->delete($bio->profile_picture);
        }
        $path = $request->file('profile_picture')->store('profiles', 'public');
        $bio->profile_picture = $path;
    }

    if($request->filled('bio')) {
        $bio->bio = $request->bio;
    }

    $bio->save();

    return response()->json($bio);
}

}
