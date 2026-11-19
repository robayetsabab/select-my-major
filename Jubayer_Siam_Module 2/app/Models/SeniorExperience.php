<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SeniorExperience extends Model
{
    protected $fillable = [
        'major_id', 'subfield_id', 'student_name', 'batch', 'status', 'stage_label', 'current_position',
        'headline', 'story', 'advice', 'challenges', 'best_part', 'skills',
        'satisfaction', 'difficulty', 'would_choose_again', 'helpful_count', 'is_published',
    ];

    protected $casts = [
        'skills' => 'array',
        'would_choose_again' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function major(): BelongsTo { return $this->belongsTo(Major::class); }
    public function subfield(): BelongsTo { return $this->belongsTo(Subfield::class); }
    public function voters(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'experience_votes')->withTimestamps();
    }

    public function scopePublished(Builder $query): Builder { return $query->where('is_published', true); }

    /** Filters: q, major (slug), status (current|completed), sort (latest|helpful|rating). */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['q'])) {
            $term = '%' . addcslashes(trim($filters['q']), '%_\\') . '%';
            $query->where(function ($b) use ($term) {
                $b->where('student_name', 'like', $term)
                    ->orWhere('headline', 'like', $term)
                    ->orWhere('story', 'like', $term)
                    ->orWhere('advice', 'like', $term)
                    ->orWhere('current_position', 'like', $term);
            });
        }
        if (!empty($filters['major'])) {
            $query->whereHas('major', fn ($b) => $b->where('slug', $filters['major']));
        }
        if (in_array($filters['status'] ?? null, ['current', 'completed'], true)) {
            $query->where('status', $filters['status']);
        }
        match ($filters['sort'] ?? 'latest') {
            'helpful' => $query->orderByDesc('helpful_count')->orderByDesc('id'),
            'rating'  => $query->orderByDesc('satisfaction')->orderByDesc('helpful_count'),
            default   => $query->orderByDesc('id'),
        };
        return $query;
    }
}
