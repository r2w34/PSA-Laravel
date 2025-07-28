<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'sport_id', 'coach_id', 'description', 'schedule', 'start_time', 'end_time', 'max_capacity', 'current_students', 'skill_level', 'is_active'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
        ];
    }
    
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
