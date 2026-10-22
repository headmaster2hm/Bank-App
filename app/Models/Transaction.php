<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'related_account_id',
        'type',
        'amount',
        'balance_after',
        'description',
        'reference_number',
        'status',
        'category',
        'merchant',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'balance_after' => 'decimal:2',
        ];
    }

    public static function generateReference(): string
    {
        return 'TXN' . strtoupper(Str::random(2)) . time() . random_int(1000, 9999);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function relatedAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'related_account_id');
    }

    public function isCredit(): bool
    {
        return in_array($this->type, ['deposit', 'transfer_in', 'payment']);
    }
}
