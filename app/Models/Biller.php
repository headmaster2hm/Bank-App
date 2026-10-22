<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Biller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'name',
        'category',
        'account_reference',
        'amount_due',
        'due_date',
        'autopay',
        'autopay_frequency',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount_due' => 'decimal:2',
            'due_date' => 'date',
            'autopay' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function isOverdue(): bool
    {
        return $this->due_date->isPast();
    }

    public function daysUntilDue(): int
    {
        return (int) now()->startOfDay()->diffInDays($this->due_date->startOfDay(), false);
    }

    public function dueLabel(): string
    {
        if ($this->isOverdue()) {
            $days = abs($this->daysUntilDue());

            return $days === 1 ? '1 day overdue' : $days.' days overdue';
        }

        $days = $this->daysUntilDue();

        if ($days === 0) {
            return 'Due today';
        }

        return $days === 1 ? 'Due tomorrow' : 'Due in '.$days.' days';
    }
}
