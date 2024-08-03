<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Plataform;
use App\Models\CardModel;

class SelectedLink extends Model
{
    use HasFactory;

    public function plataform(): BelongsTo
    {
        return $this->belongsTo(Plataform::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(CardModel::class, 'card_model_id');
    }
}
