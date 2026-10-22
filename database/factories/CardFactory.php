<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Card>
 */
class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'account_id' => Account::factory(),
            'card_type' => 'debit',
            'card_name' => 'Everyday Debit',
            'card_brand' => 'SecureBank',
            'last_four' => fake()->unique()->numerify('####'),
            'expiry_month' => fake()->numerify('0#'),
            'expiry_year' => (string) (now()->year + fake()->numberBetween(2, 6)),
            'status' => 'active',
            'frozen' => false,
            'online_purchases' => true,
            'international_purchases' => false,
            'atm_withdrawals' => true,
            'contactless' => true,
            'credit_limit' => null,
            'current_balance' => 0,
            'minimum_payment' => null,
            'payment_due_day' => null,
        ];
    }

    public function credit(): static
    {
        return $this->state(fn () => [
            'card_type' => 'credit',
            'card_name' => 'Rewards Credit',
            'international_purchases' => true,
            'credit_limit' => 15000,
            'current_balance' => 1200.50,
            'minimum_payment' => 40.02,
            'payment_due_day' => 14,
        ]);
    }

    public function frozen(): static
    {
        return $this->state(fn () => ['frozen' => true]);
    }
}
