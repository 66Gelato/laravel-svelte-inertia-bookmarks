<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(Bookmark::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
