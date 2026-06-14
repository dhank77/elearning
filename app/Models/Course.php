<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['teacher_id', 'title', 'description', 'cover_image_path', 'status', 'price', 'completion_percentage', 'last_saved_at'])]
class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(CourseModule::class)->orderBy('position');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(CourseOrder::class);
    }

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'completion_percentage' => 'integer',
            'last_saved_at' => 'datetime',
        ];
    }
}
