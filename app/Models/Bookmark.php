<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    protected $fillable = [
        'url',
        'title',
        'description',
    ];

    // user_id
    // each bookmark belongs to one user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
