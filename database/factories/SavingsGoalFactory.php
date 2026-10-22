<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\SavingsGoal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SavingsGoal>
 */
class SavingsGoalFactory extends Factory
{
    protected $model = SavingsGoal::class;

    public function definition(): array
    {
        $target = fake()->randomFloat(2, 1000, 40000);

        return [
            'user_id' => User::factory(),
            'account_id' => Account::factory(),
            'name' => fake()->randomElement(['Emergency Fund', 'New Vehicle', 'Home Deposit', 'Holiday Fund']),
            'purpose' => fake()->sentence(4),
            'target_amount' => $target,
            'current_amount' => round($target * fake()->randomFloat(2, 0.05, 0.8), 2),
            'target_date' => now()->addMonths(fake()->numberBetween(3, 36)),
            'status' => 'active',
        ];
    }

    public function complete(): static
    {
        return $this->state(fn (array $attributes) => [
            'current_amount' => $attributes['target_amount'],
            'status' => 'complete',
        ]);
    }
}
