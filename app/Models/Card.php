<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'card_type',
        'card_name',
        'card_brand',
        'last_four',
        'expiry_month',
        'expiry_year',
        'status',
        'frozen',
        'online_purchases',
        'international_purchases',
        'atm_withdrawals',
        'contactless',
        'credit_limit',
        'current_balance',
        'minimum_payment',
        'payment_due_day',
    ];

    protected function casts(): array
    {
        return [
            'frozen' => 'boolean',
            'online_purchases' => 'boolean',
            'international_purchases' => 'boolean',
            'atm_withdrawals' => 'boolean',
            'contactless' => 'boolean',
            'credit_limit' => 'decimal:2',
            'current_balance' => 'decimal:2',
            'minimum_payment' => 'decimal:2',
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

    public function isCredit(): bool
    {
        return $this->card_type === 'credit';
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && ! $this->frozen;
    }

    public function availableCredit(): float
    {
        if (! $this->isCredit() || ! $this->credit_limit) {
            return 0.0;
        }

        return max(0.0, (float) $this->credit_limit - (float) $this->current_balance);
    }

    public function utilisationPercentage(): float
    {
        if (! $this->isCredit() || ! $this->credit_limit) {
            return 0.0;
        }

        return round(((float) $this->current_balance / (float) $this->credit_limit) * 100, 1);
    }

    public function maskedNumber(): string
    {
        return '•••• '.$this->last_four;
    }

    public function expiryLabel(): ?string
    {
        if (! $this->expiry_month || ! $this->expiry_year) {
            return null;
        }

        $months = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
            '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug',
            '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec',
        ];

        return ($months[$this->expiry_month] ?? $this->expiry_month).' '.$this->expiry_year;
    }
}
