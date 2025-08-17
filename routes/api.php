<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BioController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//register
Route::post('/register', [AuthController::class, 'register']);
//login
Route::post('/login', [AuthController::class, 'login']);

//authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    //logout
    Route::post('/logout', [AuthController::class, 'logout']);
    //user bio
    Route::get('/bio', [AuthController::class, 'getBio']);
    Route::put('/bio', [AuthController::class, 'updateBio']);
    Route::get('/bio/{id}', [BioController::class, 'getBioById']);

    //search for user(s)
    Route::get('/users', [MessageController::class, 'searchUser']);
    Route::get('/user', [MessageController::class, 'getUser']);
    Route::get('/user/{id}', [MessageController::class, 'getUserById']);

    //test route
    Route::get('/test', [AuthController::class, 'test']); 
});


    

    