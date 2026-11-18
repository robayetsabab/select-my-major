<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class QuizAttempt extends Model {
 protected $fillable=['user_id','session_key','answers','scores','recommended_major','answered_count'];
 protected function casts(): array { return ['answers'=>'array','scores'=>'array']; }
}