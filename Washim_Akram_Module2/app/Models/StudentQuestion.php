<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'major_id', 'type', 'category', 'title', 'body', 'status', 'admin_reply',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function scopeVisibleTo($query, $user)
    {
        if ($user && $user->role === 'admin') {
            return $query;
        }

        return $query->where(function ($q) use ($user) {
            $q->where('status', 'published');
            if ($user) {
                $q->orWhere('user_id', $user->id);
            }
        });
    }
}
