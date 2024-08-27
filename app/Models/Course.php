<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id', 'title', 'description', 'price'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(CourseVideo::class, 'course_id');
    }
}
