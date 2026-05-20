<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['track_id', 'revenue_date', 'amount', 'currency', 'source', 'streams', 'platform', 'country', 'subscription_type', 'expected_amount_rub', 'fx_rate_to_rub', 'is_manual_corrected'])]
class RevenueEntry extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'revenue_date' => 'date',
            'amount' => 'decimal:2',
            'expected_amount_rub' => 'decimal:2',
            'fx_rate_to_rub' => 'decimal:6',
            'is_manual_corrected' => 'boolean',
        ];
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    public function adjustments(): HasMany
    {
        return $this->hasMany(ManualAdjustment::class);
    }
}
