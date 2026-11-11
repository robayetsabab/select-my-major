<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Career extends Model
{
    protected $fillable = [
        'major_id', 'title', 'level', 'description', 'opportunities', 'sort_order', 'slug',
        'summary', 'responsibilities', 'skills', 'industries', 'previous_roles', 'next_roles',
        'related_roles', 'experience_range', 'image_url', 'youtube_url',
    ];

    protected $casts = [
        'responsibilities' => 'array', 'skills' => 'array', 'industries' => 'array',
        'previous_roles' => 'array', 'next_roles' => 'array', 'related_roles' => 'array',
    ];

    public function getRouteKeyName(): string { return 'slug'; }
    public function major(): BelongsTo { return $this->belongsTo(Major::class); }
}
