<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    protected $fillable = [
        'user_id', 'answers', 'scores', 'percentages',
        'top_major_id', 'runner_up_major_id', 'confidence', 'is_tie',
    ];

    protected $casts = [
        'answers' => 'array', 'scores' => 'array', 'percentages' => 'array', 'is_tie' => 'boolean',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function topMajor(): BelongsTo { return $this->belongsTo(Major::class, 'top_major_id'); }
    public function runnerUp(): BelongsTo { return $this->belongsTo(Major::class, 'runner_up_major_id'); }
}
