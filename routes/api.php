<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::apiResource('/users', UserController::class);
Route::post('/login', [UserController::class, 'login']);

Route::group([ 'middleware' => 'auth:sanctum'], function(){
    Route::apiResource('/cards', CardController::class);
    Route::post('/cards/test', [CardController::class, 'addLink']);
});