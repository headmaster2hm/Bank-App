<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_type',
        'title',
        'location',
        'ip_address',
        'device_name',
        'is_suspicious',
        'occurred_at',
    ];

    protected function casts(): array
    {
        return [
            'is_suspicious' => 'boolean',
            'occurred_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tone(): string
    {
        return match($this->event_type) {
            'login' => 'success',
            'failed_login', 'password_change' => 'warning',
            default => 'neutral',
        };
    }

    public function typeLabel(): string
    {
        return match($this->event_type) {
            'login' => 'Sign-in',
            'logout' => 'Sign-out',
            'failed_login' => 'Failed sign-in attempt',
            'password_change' => 'Password change',
            'card_frozen' => 'Card frozen',
            'card_unfrozen' => 'Card unfrozen',
            'transfer' => 'Transfer',
            default => 'Account activity',
        };
    }
}
