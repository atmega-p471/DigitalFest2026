<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['track_id', 'revenue_date', 'amount', 'currency', 'source'])]
class RevenueEntry extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'revenue_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }
}
