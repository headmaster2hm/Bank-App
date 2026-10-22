<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrustedDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_name',
        'device_type',
        'location',
        'last_used_at',
        'trusted_at',
    ];

    protected function casts(): array
    {
        return [
            'last_used_at' => 'datetime',
            'trusted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isCurrent(): bool
    {
        return $this->device_name === 'This browser';
    }
}
