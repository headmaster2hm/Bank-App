<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Loan>
 */
class LoanFactory extends Factory
{
    protected $model = Loan::class;

    public function definition(): array
    {
        $original = fake()->randomFloat(2, 5000, 30000);
        $balance = round($original * fake()->randomFloat(2, 0.3, 0.9), 2);

        return [
            'user_id' => User::factory(),
            'loan_type' => fake()->randomElement(['auto', 'personal', 'mortgage']),
            'loan_name' => fake()->randomElement(['Auto Loan', 'Personal Loan', 'Home Mortgage']),
            'reference_number' => 'SB-LN-'.Str::upper(Str::random(6)),
            'original_amount' => $original,
            'balance' => $balance,
            'interest_rate' => fake()->randomFloat(2, 3, 9),
            'next_payment_amount' => fake()->randomFloat(2, 100, 600),
            'next_payment_date' => now()->addDays(fake()->numberBetween(1, 28)),
            'term_months' => 60,
            'payments_remaining' => fake()->numberBetween(3, 55),
            'first_payment_date' => now()->subMonths(12),
            'status' => 'active',
        ];
    }
}
