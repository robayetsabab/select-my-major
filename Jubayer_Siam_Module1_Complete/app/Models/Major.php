<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    protected $fillable = [
        'name', 'slug', 'tagline', 'overview', 'reasons', 'best_for', 'accent',
        'sort_order', 'image_url', 'video_url',
    ];

    protected $casts = ['reasons' => 'array'];

    public function getRouteKeyName(): string { return 'slug'; }
    public function subfields(): HasMany { return $this->hasMany(Subfield::class); }
    public function certifications(): HasMany { return $this->hasMany(Certification::class); }
    public function careers(): HasMany { return $this->hasMany(Career::class); }
}
