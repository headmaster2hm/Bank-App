<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balances_visible_by_default',
        'two_factor_enabled',
        'login_alerts',
        'payment_alerts',
        'promotional_emails',
        'paperless_statements',
        'statement_format',
        'time_zone',
    ];

    protected function casts(): array
    {
        return [
            'balances_visible_by_default' => 'boolean',
            'two_factor_enabled' => 'boolean',
            'login_alerts' => 'boolean',
            'payment_alerts' => 'boolean',
            'promotional_emails' => 'boolean',
            'paperless_statements' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
