<?php

namespace Database\Factories;

use App\Models\InvestmentHolding;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvestmentHolding>
 */
class InvestmentHoldingFactory extends Factory
{
    protected $model = InvestmentHolding::class;

    public function definition(): array
    {
        $purchase = fake()->randomFloat(2, 20, 500);

        return [
            'user_id' => User::factory(),
            'symbol' => fake()->unique()->randomElement(['VTI', 'VXUS', 'BND', 'AAPL', 'MSFT', 'IEMG', 'VOO']),
            'name' => fake()->randomElement([
                'Total Stock Market Index',
                'International Stock Index',
                'Total Bond Market Index',
                'Sample Equity Holding',
            ]),
            'asset_class' => fake()->randomElement(['Equity', 'Fixed income', 'International']),
            'quantity' => fake()->randomFloat(2, 2, 60),
            'purchase_price' => $purchase,
            'market_price' => round($purchase * fake()->randomFloat(2, 0.75, 1.35), 2),
        ];
    }
}
