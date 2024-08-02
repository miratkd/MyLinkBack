<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCardRequest;
use App\Models\CardModel;
use App\Http\Resources\CardResource;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return CardResource::collection($request->user()->cards()->paginate(10));
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
    public function store(CreateCardRequest $request)
    {
        $card = $request->all();
        $card['user_id'] = $request->user()->id;
        if (!$request['image_url']) $card['image_url'] = 'https://friconix.com/png/fi-ctluxx-anonymous-user-circle-solid.png'; 
        return new CardResource(CardModel::create($card));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $request->validate([
            'email' => 'email'
        ]);
        $card = CardModel::find($id);
        if (!$card) return Response()->json(['message'=>'Not found'],404);
        if ($card->user()->first()->id != $request->user()->id) return Response()->json(['message'=>'You can only edit yours own cards'],401);
        if ($request['email']) $card->display_email = $request['email'];
        if ($request['title']) $card->title = $request['title'];
        if ($request['description']) $card->display_email = $request['description'];
        if ($request['mainColor']) $card->main_color = $request['mainColor'];
        if ($request['imageUrl']) $card->image_url = $request['imageUrl'];
        $card->save();
        return new CardResource($card);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $card = CardModel::find($id);
        if (!$card) return Response()->json(['message'=>'Not found'],404);
        if ($card->user()->first()->id != $request->user()->id) return Response()->json(['message'=>'You can only delete yours own cards'],401);
        $card->delete();
        return Response()->json(['message'=>'Card deleted'], 200);
    }

    public function addLink()
    {
        return 'add link';
    }
}
