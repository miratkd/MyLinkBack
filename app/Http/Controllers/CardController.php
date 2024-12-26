<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCardRequest;
use App\Http\Requests\AddLinkRequest;
use App\Models\CardModel;
use App\Models\Plataform;
use App\Models\SelectedLink;
use App\Http\Resources\CardResource;
use App\Http\Resources\FullCardResource;
use App\Http\Resources\PublicCardResource;
use App\Http\Resources\PlataformResource;

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
        if (!$request['image_url']) $card['image_url'] = 'https://github.com/miratkd/MyLinkBack/blob/main/app/Assets/user.png?raw=true'; 
        return new CardResource(CardModel::create($card));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new FullCardResource(CardModel::find($id));
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

    public function getPlataforms()
    {
        return PlataformResource::collection(Plataform::all());
    }

    public function addLink(AddLinkRequest $request)
    {
        $plataform = Plataform::find($request['plataformId']);
        $card = CardModel::find($request['cardId']);
        if (!$plataform) return Response()->json(['message'=>'Plataform not found'],404);
        if (!$card) return Response()->json(['message'=>'Card not found'],404);
        if ($card->user()->first()->id != $request->user()->id) return Response()->json(['message'=>'You can not add a link to this card'],401);
        $link = new SelectedLink();
        $link->link = $request['link'];
        $link->plataform_id = $request['plataformId'];
        $link->card_model_id = $request['cardId'];
        if ($request['position']) $link->position = $request['position'];
        else $link->position = Sizeof($card->links()->get()) + 1;
        $link->save();
        return new FullCardResource($card);
    }

    public function removeLink(string $id, Request $request) {
        $link = SelectedLink::find($id);
        if (!$link) return Response()->json(['message'=>'Link not found'],404);
        if ($link->card()->first()->user()->first()->id != $request->user()->id) return Response()->json(['message'=>'You can not remove a link from this card, you are not the owner'],401);
        $link->delete();
        return new FullCardResource($link->card()->first());
    }

    public function updateLink (string $id, Request $request) {
        $link = SelectedLink::find($id);
        $plataform = Plataform::find($request['plataformId']);
        if (!$link) return Response()->json(['message'=>'Link not found'],404);
        if (!$plataform) return Response()->json(['message'=>'Plataform not found'],404);
        if ($link->card()->first()->user()->first()->id != $request->user()->id) return Response()->json(['message'=>'You can not edit a link from this card, you are not the owner'],401);
        if ($request['link']) $link->link = $request['link'];
        if ($request['plataformId']) $link->plataform_id = $request['plataformId'];
        if ($request['position']) $link->position = $request['position'];
        $link->save();
        return new FullCardResource($link->card()->first());
    }

    public function updateCardOrder(string $id, Request $request) {
        $card = CardModel::find($id);
        $links = $card->links()->get();
        $updateLinks = $request['links'];
        if (!$card) return Response()->json(['message'=>'Card not found'],404);
        if (!$updateLinks) return Response()->json(['message'=>'Link list missing'],404);
        if ($card()->user()->first()->id != $request->user()->id) return Response()->json(['message'=>'You can not edit a link from this card, you are not the owner'],401);
        foreach ($links as $link){
            foreach ($updateLinks as $updateLink){
                if ($link->id == $updateLink[0]){
                    $link->position = $updateLink[1];
                    $link->save();
                }
            }
        }
        return 'foi carai';
    }

    public function getCard(string $id)
    {
        return new PublicCardResource(CardModel::find($id));
    }
}
