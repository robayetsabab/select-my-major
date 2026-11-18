<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CareerStory extends Model {
 protected $fillable=['major_id','slug','name','role_title','country','organization','short_bio','education','first_job','current_position','skills','achievements','career_steps','learning_takeaways','photo_url','wikipedia_url','professional_url','source_url','is_featured'];
 protected function casts(): array { return ['skills'=>'array','achievements'=>'array','career_steps'=>'array','is_featured'=>'boolean']; }
 public function getRouteKeyName(): string { return 'slug'; }
 public function major(): BelongsTo { return $this->belongsTo(Major::class); }
}