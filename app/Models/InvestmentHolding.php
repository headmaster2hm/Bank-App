<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentHolding extends Model
{
    use HasFactory;

    protected $table = 'investment_holdings';

    protected $fillable = [
        'user_id',
        'symbol',
        'name',
        'asset_class',
        'quantity',
        'purchase_price',
        'market_price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:6',
            'purchase_price' => 'decimal:2',
            'market_price' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function marketValue(): float
    {
        return round((float) $this->quantity * (float) $this->market_price, 2);
    }

    public function costBasis(): float
    {
        return round((float) $this->quantity * (float) $this->purchase_price, 2);
    }

    public function gainLoss(): float
    {
        return round($this->marketValue() - $this->costBasis(), 2);
    }

    public function gainLossPercentage(): float
    {
        $basis = $this->costBasis();

        if ($basis <= 0) {
            return 0.0;
        }

        return round(($this->gainLoss() / $basis) * 100, 2);
    }

    public function isGain(): bool
    {
        return $this->gainLoss() >= 0;
    }
}
