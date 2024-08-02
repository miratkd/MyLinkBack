<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\user;

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
}
