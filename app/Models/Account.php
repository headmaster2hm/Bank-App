<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_number',
        'account_type',
        'account_name',
        'balance',
        'available_balance',
        'currency',
        'status',
        'interest_rate',
        'credit_limit',
    ];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
            'available_balance' => 'decimal:2',
            'interest_rate' => 'decimal:2',
            'credit_limit' => 'decimal:2',
        ];
    }

    public static function generateAccountNumber(): string
    {
        return '4' . str_pad(random_int(0, 99999999999), 11, '0', STR_PAD_LEFT);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class)->latest();
    }

    public function maskedNumber(): string
    {
        return '****' . substr($this->account_number, -4);
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->account_type) {
            'checking' => 'banknotes',
            'savings' => 'archive-box',
            'credit' => 'credit-card',
            default => 'building-library',
        };
    }
}
