<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'date_of_birth',
        'ssn_last_four',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
        ];
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function beneficiaries(): HasMany
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function bankNotifications(): HasMany
    {
        return $this->hasMany(BankNotification::class);
    }

    public function savingsGoals(): HasMany
    {
        return $this->hasMany(SavingsGoal::class);
    }

    public function billers(): HasMany
    {
        return $this->hasMany(Biller::class);
    }

    public function scheduledTransfers(): HasMany
    {
        return $this->hasMany(ScheduledTransfer::class);
    }

    public function trustedDevices(): HasMany
    {
        return $this->hasMany(TrustedDevice::class);
    }

    public function securityEvents(): HasMany
    {
        return $this->hasMany(SecurityEvent::class);
    }

    public function messageThreads(): HasMany
    {
        return $this->hasMany(MessageThread::class);
    }

    public function investmentHoldings(): HasMany
    {
        return $this->hasMany(InvestmentHolding::class);
    }

    public function preference(): HasOne
    {
        return $this->hasOne(UserPreference::class);
    }

    public function creditProfile(): HasOne
    {
        return $this->hasOne(CreditProfile::class);
    }

    public function getTotalBalanceAttribute(): float
    {
        return $this->accounts->sum('balance');
    }

    public function firstName(): string
    {
        return explode(' ', trim((string) $this->name))[0] ?? (string) $this->name;
    }

    public function initials(): string
    {
        $parts = preg_split('/\s+/', trim((string) $this->name)) ?: [];

        $letters = array_map(
            static fn (string $part): string => mb_strtoupper(mb_substr($part, 0, 1)),
            array_slice(array_filter($parts), 0, 2)
        );

        return implode('', $letters) ?: 'SB';
    }
}
