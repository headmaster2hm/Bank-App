<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-2 years', 'now');

        return [
            'user_id' => User::factory(),
            'account_id' => Account::factory(),
            'document_type' => fake()->randomElement(['statement', 'statement', 'tax', 'notice', 'loan', 'card', 'agreement']),
            'title' => fake()->randomElement(['Monthly checking statement', 'Monthly savings statement', 'Annual consolidated tax summary', 'Account agreement summary']),
            'period_label' => $date->format('F Y'),
            'document_date' => $date,
            'file_size_label' => 'PDF · '.fake()->numberBetween(120, 500).' KB',
            'status' => 'available',
        ];
    }

    public function statement(): static
    {
        return $this->state(fn () => ['document_type' => 'statement']);
    }
}
