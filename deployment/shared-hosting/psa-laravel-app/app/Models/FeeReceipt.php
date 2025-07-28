<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FeeReceipt extends Model
{
    use LogsActivity;

    protected $fillable = [
        'receipt_number',
        'payment_id',
        'student_id',
        'amount',
        'discount',
        'balance',
        'payment_mode',
        'paid_by',
        'paid_on',
        'remarks',
        'pdf_path',
        'is_printed',
        'printed_at',
        'generated_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'balance' => 'decimal:2',
        'paid_on' => 'datetime',
        'is_printed' => 'boolean',
        'printed_at' => 'datetime',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function generatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['receipt_number', 'amount', 'payment_mode', 'is_printed'])
            ->logOnlyDirty();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($receipt) {
            if (empty($receipt->receipt_number)) {
                $receipt->receipt_number = 'RCP' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
