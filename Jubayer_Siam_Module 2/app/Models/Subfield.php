<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function experiences(): HasMany { return $this->hasMany(SeniorExperience::class); }

    /** One filter used by both the web page and the REST API (q, major, difficulty, tool). */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['q'])) {
            $term = '%' . addcslashes(trim($filters['q']), '%_\\') . '%';
            $query->where(function ($b) use ($term) {
                $b->where('name', 'like', $term)
                    ->orWhere('summary', 'like', $term)
                    ->orWhere('details', 'like', $term)
                    ->orWhere('main_focus', 'like', $term)
                    ->orWhere('real_world_example', 'like', $term)
                    ->orWhere('tools', 'like', $term);
            });
        }
        if (!empty($filters['major'])) {
            $query->whereHas('major', fn ($b) => $b->where('slug', $filters['major']));
        }
        if (!empty($filters['difficulty'])) {
            $query->where('difficulty', $filters['difficulty']);
        }
        if (!empty($filters['tool'])) {
            $query->where('tools', 'like', '%' . addcslashes(trim($filters['tool']), '%_\\') . '%');
        }
        return $query;
    }
}
