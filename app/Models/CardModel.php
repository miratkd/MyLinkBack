<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\user;
use App\Models\SelectedLink;

class CardModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'display_email',
        'main_color',
        'description',
        'image_url',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(user::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(SelectedLink::class);
    }
}
