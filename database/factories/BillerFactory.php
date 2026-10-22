<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Biller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Biller>
 */
class BillerFactory extends Factory
{
    protected $model = Biller::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'account_id' => Account::factory(),
            'name' => fake()->randomElement(['Metro Electric', 'FiberLink Internet', 'Harbor Property Mgmt', 'Gymnasium Membership']),
            'category' => fake()->randomElement(['Utilities', 'Housing', 'Health', 'Insurance']),
            'account_reference' => strtoupper(fake()->lexify('??')).'-'.fake()->unique()->numerify('#####'),
            'amount_due' => fake()->randomFloat(2, 15, 900),
            'due_date' => now()->addDays(fake()->numberBetween(1, 25)),
            'autopay' => false,
            'autopay_frequency' => null,
            'status' => 'due',
        ];
    }

    public function overdue(): static
    {
        return $this->state(fn () => ['due_date' => now()->subDays(fake()->numberBetween(1, 12))]);
    }

    public function autopay(): static
    {
        return $this->state(fn () => ['autopay' => true, 'autopay_frequency' => 'monthly']);
    }
}
