<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loan_type',
        'loan_name',
        'reference_number',
        'original_amount',
        'balance',
        'interest_rate',
        'next_payment_amount',
        'next_payment_date',
        'term_months',
        'payments_remaining',
        'first_payment_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'original_amount' => 'decimal:2',
            'balance' => 'decimal:2',
            'interest_rate' => 'decimal:2',
            'next_payment_amount' => 'decimal:2',
            'next_payment_date' => 'date',
            'first_payment_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function progressPercentage(): float
    {
        if ((float) $this->original_amount <= 0) {
            return 0.0;
        }

        $repaid = (float) $this->original_amount - (float) $this->balance;

        return round(max(0.0, min(100.0, ($repaid / (float) $this->original_amount) * 100)), 1);
    }

    public function remainingInterest(): float
    {
        $payments = max(0, (int) $this->payments_remaining);
        $payment = (float) $this->next_payment_amount;

        return round($payment * $payments - (float) $this->balance, 2);
    }

    public function daysUntilPayment(): int
    {
        return (int) now()->startOfDay()->diffInDays($this->next_payment_date->startOfDay(), false);
    }
}
