<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $table = 'payments'; // Use payments table as fees

    protected $fillable = [
        'student_id',
        'amount',
        'payment_date',
        'due_date',
        'status',
        'payment_method',
        'transaction_id',
        'notes'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Map payment status to fee status
    public function getStatusAttribute($value)
    {
        return match($value) {
            'completed' => 'paid',
            'pending' => 'pending',
            'failed' => 'pending',
            default => 'pending'
        };
    }

    // Use payment_date as due_date if due_date is not set
    public function getDueDateAttribute($value)
    {
        return $value ?? $this->payment_date;
    }
}