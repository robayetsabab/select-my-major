<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizQuestion extends Model
{
    protected $fillable = ['category', 'question', 'hint', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function options(): HasMany { return $this->hasMany(QuizOption::class)->orderBy('sort_order'); }
}
