<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
        $balance = fake()->randomFloat(2, 250, 40000);

        return [
            'user_id' => User::factory(),
            'account_number' => Account::generateAccountNumber(),
            'account_type' => 'checking',
            'account_name' => fake()->randomElement(['Premium Checking', 'Everyday Checking', 'High-Yield Savings', 'Premier Savings']),
            'balance' => $balance,
            'available_balance' => $balance,
            'currency' => 'USD',
            'status' => 'active',
            'interest_rate' => 0,
            'credit_limit' => null,
        ];
    }

    public function checking(): static
    {
        return $this->state(fn () => [
            'account_type' => 'checking',
            'account_name' => 'Premium Checking',
            'interest_rate' => 0,
        ]);
    }

    public function savings(): static
    {
        return $this->state(fn () => [
            'account_type' => 'savings',
            'account_name' => 'High-Yield Savings',
            'interest_rate' => 4.50,
        ]);
    }

    public function credit(): static
    {
        return $this->state(fn () => [
            'account_type' => 'credit',
            'account_name' => 'Rewards Credit Card',
            'interest_rate' => 0,
            'credit_limit' => 10000,
        ]);
    }
}
