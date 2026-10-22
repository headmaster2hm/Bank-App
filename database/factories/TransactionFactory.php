<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $type = fake()->randomElement(['deposit', 'withdrawal']);

        return [
            'account_id' => Account::factory(),
            'type' => $type,
            'amount' => $type === 'deposit'
                ? fake()->randomFloat(2, 100, 5000)
                : fake()->randomFloat(2, 5, 400),
            'balance_after' => fake()->randomFloat(2, 1000, 30000),
            'description' => fake()->randomElement([
                'Grocery Store Purchase',
                'Monthly Subscription',
                'Direct Deposit - Salary',
                'Utility Payment',
            ]),
            'merchant' => fake()->company(),
            'category' => fake()->randomElement(['grocery', 'utilities', 'dining', 'shopping', 'income']),
            'reference_number' => Transaction::generateReference(),
            'status' => 'completed',
            'created_at' => fake()->dateTimeBetween('-90 days', 'now'),
        ];
    }

    public function withdrawal(): static
    {
        return $this->state(fn () => ['type' => 'withdrawal']);
    }

    public function deposit(): static
    {
        return $this->state(fn () => ['type' => 'deposit']);
    }
}
