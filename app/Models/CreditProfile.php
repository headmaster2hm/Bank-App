<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'score',
        'range_label',
        'previous_score',
        'month_over_month_change',
        'updated_at_date',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'integer',
            'previous_score' => 'integer',
            'month_over_month_change' => 'integer',
            'updated_at_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tone(): string
    {
        return match(true) {
            $this->score >= 780 => 'success',
            $this->score >= 700 => 'info',
            $this->score >= 620 => 'warning',
            default => 'danger',
        };
    }

    public function change(): int
    {
        return (int) ($this->month_over_month_change ?? 0);
    }

    public function changeLabel(): string
    {
        $change = $this->change();

        if ($change === 0) {
            return 'Unchanged this month';
        }

        return ($change > 0 ? '+' : '').$change.' from last month';
    }
}
