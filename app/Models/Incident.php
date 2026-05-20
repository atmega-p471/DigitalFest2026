<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['track_id', 'artist_id', 'type', 'message', 'deviation_percent', 'meta', 'resolved_at'])]
class Incident extends Model
{
    protected function casts(): array
    {
        return [
            'deviation_percent' => 'decimal:2',
            'meta' => 'array',
            'resolved_at' => 'datetime',
        ];
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }
}
