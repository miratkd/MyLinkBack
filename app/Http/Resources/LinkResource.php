<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $plataform = $this->plataform()->first();
        return [
            'id' => $this->id,
            'link' => $this->link,
            'position' => $this->position,
            'icon' => $plataform->img_url,
            'plataformName' => $plataform->name,
            'color' => $plataform->color
        ];
    }
}
