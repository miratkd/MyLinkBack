<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;

Route::apiResource('/users', UserController::class);
Route::post('/login', [UserController::class, 'login']);
Route::get('/card/{id}', [CardController::class, 'getCard']);

Route::group([ 'middleware' => 'auth:sanctum'], function(){
    Route::apiResource('/cards', CardController::class);
    Route::post('/addLink', [CardController::class, 'addLink']);
    Route::delete('/removeLink/{id}', [CardController::class, 'removeLink']);
    Route::put('/updateLink/{id}', [CardController::class, 'updateLink']);
    Route::get('plataforms', [CardController::class, 'getPlataforms']);
});