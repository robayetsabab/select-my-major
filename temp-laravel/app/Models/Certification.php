<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    protected $fillable = [
        'major_id', 'name', 'provider', 'type', 'level',
        'price_usd', 'price_note', 'has_free_option', 'source_url', 'description',
    ];

    protected $casts = ['has_free_option' => 'boolean'];

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function getPriceLabelAttribute(): string
    {
        if ($this->price_usd === null) {
            return 'Varies';
        }
        if ((float) $this->price_usd == 0.0) {
            return 'Free';
        }
        return '$' . number_format($this->price_usd, 0) . ' (approx.)';
    }
}
