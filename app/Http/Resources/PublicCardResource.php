<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PublicLinkResource;

class FullCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = null;
    public function toArray(Request $request): array
    {
        return [
            'mainColor' => $this->main_color,
            'displayEmail' => $this->display_email,
            'imageUrl' => $this->image_url,
            'title' => $this->title,
            'description' => $this->description,
            'links' => PublicLinkResource::collection($this->links()->orderBy('position')->get())
        ];
    }
}
