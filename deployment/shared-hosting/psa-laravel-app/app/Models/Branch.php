<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Branch extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'email',
        'manager_id',
        'settings',
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function coaches(): HasMany
    {
        return $this->hasMany(Coach::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function sports(): HasMany
    {
        return $this->hasMany(Sport::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'code', 'manager_id', 'is_active'])
            ->logOnlyDirty();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($branch) {
            if (empty($branch->code)) {
                $branch->code = 'BR' . str_pad(static::count() + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
