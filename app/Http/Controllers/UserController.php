<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json('Method is not supported for this route',405);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $response = new UserResource(User::create($request->all()));
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json('Method is not supported for this route',405);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json('Method is not supported for this route',405);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json('Method is not supported for this route',405);
    }

    public function login(LoginRequest $request){
        $credentials = json_decode($request->getContent(), true);
        if (Auth::attempt($credentials)){
            /** @var \App\Models\MyUserModel $user **/
            $user = Auth::user();
            return response()->json([
                'message' => 'Token created',
                'type' => 'Bearer',
                'token' => $user->createToken('user-token', [], now()->addHours(6))->plainTextToken,
                'duration' => '6 hours'
            ], 201);
        }
        return response()->json(['error' => 'Wrong credentials'],403);
    }
}
