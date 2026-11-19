<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    /** One filter used by both the web page and the REST API (q, major, level, industry). */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['q'])) {
            $term = '%' . addcslashes(trim($filters['q']), '%_\\') . '%';
            $query->where(function ($b) use ($term) {
                $b->where('title', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhere('summary', 'like', $term)
                    ->orWhere('opportunities', 'like', $term);
            });
        }
        if (!empty($filters['major'])) {
            $query->whereHas('major', fn ($b) => $b->where('slug', $filters['major']));
        }
        if (!empty($filters['level'])) {
            $query->where('level', $filters['level']);
        }
        if (!empty($filters['industry'])) {
            $query->whereJsonContains('industries', $filters['industry']);
        }
        return $query;
    }
}
