<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Certificate extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'student_id',
        'template_name',
        'certificate_data',
        'issued_date',
        'certificate_number',
        'status',
        'file_path',
        'issued_by',
        'branch_id',
    ];

    protected function casts(): array
    {
        return [
            'certificate_data' => 'array',
            'issued_date' => 'date',
        ];
    }

    // Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['student_id', 'template_name', 'status', 'issued_date'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
