<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subfield extends Model
{
    protected $fillable = [
        'major_id', 'name', 'slug', 'summary', 'details', 'tools', 'sort_order',
        'main_focus', 'typical_tasks', 'applications', 'technologies', 'real_world_example',
        'difficulty', 'image_url', 'youtube_url', 'related_slugs',
    ];

    protected $casts = [
        'typical_tasks' => 'array', 'applications' => 'array',
        'technologies' => 'array', 'related_slugs' => 'array',
    ];

    public function getRouteKeyName(): string { return 'slug'; }
    public function major(): BelongsTo { return $this->belongsTo(Major::class); }
}
