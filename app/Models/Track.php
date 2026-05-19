<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'isrc', 'release_date', 'genre', 'notes'])]
class Track extends Model
{
    use HasFactory;

    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class)
            ->withPivot('share_percent')
            ->withTimestamps();
    }

    public function revenueEntries(): HasMany
    {
        return $this->hasMany(RevenueEntry::class);
    }
}
