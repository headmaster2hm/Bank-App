<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'title',
        'body',
        'action_label',
        'action_url',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function categoryLabel(): string
    {
        return match($this->category) {
            'security' => 'Security',
            'payment' => 'Payment',
            'account' => 'Account',
            'card' => 'Card',
            'system' => 'System',
            default => 'Update',
        };
    }

    public function tone(): string
    {
        return match($this->category) {
            'security' => 'warning',
            'payment' => 'success',
            'card' => 'info',
            default => 'neutral',
        };
    }
}
