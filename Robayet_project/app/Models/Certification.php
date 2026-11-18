<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'major_id', 'name', 'provider', 'level', 'price', 'is_free', 'free_option', 'official_url', 'sort_order',
        'type', 'price_usd', 'price_note', 'has_free_option', 'source_url', 'description',
    ];

    public function getPriceAttribute($value): string
    {
        return $value ?: ($this->attributes['price_note'] ?? (($this->attributes['price_usd'] ?? null) !== null ? 'USD ' . $this->attributes['price_usd'] : 'Check provider for current pricing'));
    }

    public function getIsFreeAttribute($value): bool
    {
        return (bool) ($value || ($this->attributes['has_free_option'] ?? false));
    }

    public function getFreeOptionAttribute($value): ?string
    {
        return $value ?: (($this->attributes['has_free_option'] ?? false) ? 'Free learning options may be available. Check the provider website.' : null);
    }

    public function getOfficialUrlAttribute($value): ?string
    {
        return $value ?: ($this->attributes['source_url'] ?? null);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
