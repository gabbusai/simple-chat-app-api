<?php

namespace App\Http\Controllers;

use App\Models\Bio;
use App\Models\User;
use Illuminate\Http\Request;

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
}
