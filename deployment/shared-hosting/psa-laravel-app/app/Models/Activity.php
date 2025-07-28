<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'description', 'user_id', 'entity_id', 'entity_type', 'metadata'
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array'
        ];
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
