<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'student_id', 'name', 'phone', 'email', 'date_of_birth', 'address', 'emergency_contact', 'medical_notes', 'sport_id', 'batch_id', 'skill_level', 'joining_date', 'is_active', 'profile_image_url'
    ];

    protected function casts(): array
    {
        return [
            'emergency_contact' => 'array',
            'date_of_birth' => 'date',
            'joining_date' => 'datetime',
            'is_active' => 'boolean'
        ];
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
