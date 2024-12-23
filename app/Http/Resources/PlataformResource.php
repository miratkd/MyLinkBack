<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlataformResource extends JsonResource
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
            'name' => $this->name,
            'imgUrl' => $this->img_url,
            'color' => $this->color,
            'id' => $this->id
        ];
    }
}
