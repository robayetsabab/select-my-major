<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'short_description', 'required_skills', 'prerequisites',
        'difficulty', 'roadmap', 'certifications', 'career_opportunities',
        'job_market_bd', 'job_market_international',
    ];

    protected $casts = [
        'required_skills' => 'array',
        'prerequisites' => 'array',
        'roadmap' => 'array',
        'certifications' => 'array',
        'career_opportunities' => 'array',
    ];

    public function questions()
    {
        return $this->hasMany(StudentQuestion::class);
    }
}
