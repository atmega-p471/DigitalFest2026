<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['created_by_user_id', 'artist_id', 'period_from', 'period_to', 'total_amount', 'currency'])]
class Report extends Model
{
    protected function casts(): array
    {
        return [
            'period_from' => 'date',
            'period_to' => 'date',
            'total_amount' => 'decimal:2',
        ];
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
