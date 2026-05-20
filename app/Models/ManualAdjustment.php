<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['revenue_entry_id', 'changed_by_user_id', 'field', 'old_value', 'new_value', 'reason'])]
class ManualAdjustment extends Model
{
    public function revenueEntry(): BelongsTo
    {
        return $this->belongsTo(RevenueEntry::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by_user_id');
    }
}
