<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = [
        'name', 'slug', 'tagline', 'overview', 'reasons', 'best_for', 'accent', 'sort_order',
        'icon', 'why_choose', 'difficulty',
    ];

    public function getReasonsAttribute($value): array
    {
        if (is_array($value)) return $value;
        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) return $decoded;
        }
        return array_values(array_filter(array_map('trim', preg_split('/\r?\n/', (string) ($this->attributes['why_choose'] ?? '')))));
    }

    public function getBestForAttribute($value): string
    {
        return $value ?: 'Students interested in exploring this field and building practical skills.';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }


    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

}
