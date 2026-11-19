<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizOption extends Model
{
    protected $fillable = ['quiz_question_id', 'label', 'scores', 'sort_order'];
    protected $casts = ['scores' => 'array'];

    public function question(): BelongsTo { return $this->belongsTo(QuizQuestion::class, 'quiz_question_id'); }
}
