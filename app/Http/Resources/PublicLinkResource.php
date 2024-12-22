<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicLinkResource extends JsonResource
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
            'link' => $this->link,
            'icon' => $plataform->img_url,
            'plataformName' => $plataform->name,
            'color' => $plataform->color
        ];
    }
}
