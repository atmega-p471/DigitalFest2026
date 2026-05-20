<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['platform', 'country', 'subscription_type', 'rate_per_stream_rub'])]
class PlatformRate extends Model
{
    protected function casts(): array
    {
        return [
            'rate_per_stream_rub' => 'decimal:6',
        ];
    }
}
