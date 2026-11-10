<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    protected $fillable = ['slug', 'name', 'icon', 'tagline', 'overview', 'why_choose', 'difficulty'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    /** why_choose is stored one reason per line */
    public function getReasonsAttribute(): array
    {
        return array_values(array_filter(array_map('trim', explode("\n", $this->why_choose))));
    }
}
