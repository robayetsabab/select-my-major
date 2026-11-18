<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'major_id', 'name', 'provider', 'level', 'price', 'is_free', 'free_option', 'official_url', 'sort_order',
    ];

    protected $casts = [
        'is_free' => 'boolean',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
