<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'category', 'key', 'value', 'description', 'is_active'
    ];

    protected function casts(): array
    {
        return [
            'value' => 'array',
            'is_active' => 'boolean'
        ];
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
