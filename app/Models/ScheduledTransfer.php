<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from_account_id',
        'to_account_id',
        'description',
        'amount',
        'frequency',
        'next_run_date',
        'end_date',
        'status',
        'last_run_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'next_run_date' => 'date',
            'end_date' => 'date',
            'last_run_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fromAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'from_account_id');
    }

    public function toAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'to_account_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function frequencyLabel(): string
    {
        return match($this->frequency) {
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'biweekly' => 'Every 2 weeks',
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly',
            'yearly' => 'Yearly',
            default => ucfirst((string) $this->frequency),
        };
    }

    public function daysUntilNextRun(): int
    {
        return (int) now()->startOfDay()->diffInDays($this->next_run_date->startOfDay(), false);
    }
}
