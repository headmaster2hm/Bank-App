<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo user
        $user = User::create([
            'name' => 'John Smith',
            'email' => 'demo@securebank.com',
            'password' => Hash::make('password'),
            'phone' => '+1 (555) 123-4567',
            'address' => '123 Main Street, New York, NY 10001',
            'date_of_birth' => '1990-05-15',
            'ssn_last_four' => '6789',
        ]);

        // Create checking account
        $checking = Account::create([
            'user_id' => $user->id,
            'account_number' => '489210003456',
            'account_type' => 'checking',
            'account_name' => 'Premium Checking',
            'balance' => 12450.00,
            'available_balance' => 12450.00,
        ]);

        // Create savings account
        $savings = Account::create([
            'user_id' => $user->id,
            'account_number' => '472310007891',
            'account_type' => 'savings',
            'account_name' => 'High-Yield Savings',
            'balance' => 25892.50,
            'available_balance' => 25892.50,
            'interest_rate' => 4.50,
        ]);

        // Create sample transactions
        $transactions = [
            ['account_id' => $checking->id, 'type' => 'deposit', 'amount' => 5200.00, 'description' => 'Direct Deposit - Salary', 'merchant' => 'ACME Corp'],
            ['account_id' => $checking->id, 'type' => 'withdrawal', 'amount' => 89.99, 'description' => 'Whole Foods Market', 'merchant' => 'Whole Foods', 'category' => 'grocery'],
            ['account_id' => $checking->id, 'type' => 'withdrawal', 'amount' => 45.50, 'description' => 'Shell Gas Station', 'merchant' => 'Shell', 'category' => 'transportation'],
            ['account_id' => $checking->id, 'type' => 'withdrawal', 'amount' => 12.99, 'description' => 'Netflix Subscription', 'merchant' => 'Netflix', 'category' => 'entertainment'],
            ['account_id' => $checking->id, 'type' => 'withdrawal', 'amount' => 156.00, 'description' => 'Electric Company Bill', 'merchant' => 'ConEdison', 'category' => 'utilities'],
            ['account_id' => $checking->id, 'type' => 'transfer_out', 'amount' => 1000.00, 'description' => 'Transfer to High-Yield Savings', 'related_account_id' => $savings->id],
            ['account_id' => $savings->id, 'type' => 'transfer_in', 'amount' => 1000.00, 'description' => 'Transfer from Premium Checking', 'related_account_id' => $checking->id],
            ['account_id' => $checking->id, 'type' => 'withdrawal', 'amount' => 67.50, 'description' => 'Uber Eats Order', 'merchant' => 'Uber Eats', 'category' => 'dining'],
            ['account_id' => $checking->id, 'type' => 'withdrawal', 'amount' => 299.00, 'description' => 'Apple Store Purchase', 'merchant' => 'Apple', 'category' => 'shopping'],
            ['account_id' => $checking->id, 'type' => 'deposit', 'amount' => 150.00, 'description' => 'Refund - Amazon', 'merchant' => 'Amazon'],
            ['account_id' => $savings->id, 'type' => 'deposit', 'amount' => 96.85, 'description' => 'Interest Payment', 'category' => 'interest'],
            ['account_id' => $checking->id, 'type' => 'withdrawal', 'amount' => 55.00, 'description' => 'Gym Membership', 'merchant' => 'Planet Fitness', 'category' => 'health'],
            ['account_id' => $checking->id, 'type' => 'withdrawal', 'amount' => 23.45, 'description' => 'Starbucks Coffee', 'merchant' => 'Starbucks', 'category' => 'dining'],
            ['account_id' => $checking->id, 'type' => 'withdrawal', 'amount' => 1200.00, 'description' => 'Rent Payment', 'merchant' => 'Apartment Complex', 'category' => 'housing'],
            ['account_id' => $checking->id, 'type' => 'deposit', 'amount' => 320.00, 'description' => 'Venmo Payment Received', 'merchant' => 'Venmo'],
        ];

        foreach ($transactions as $i => $txn) {
            $lastBalance = $txn['account_id'] === $checking->id ? $checking->balance : $savings->balance;
            Transaction::create([
                ...$txn,
                'balance_after' => $lastBalance,
                'reference_number' => 'TXN' . strtoupper(substr(uniqid(), -4)) . (1000 + $i),
                'status' => 'completed',
                'created_at' => now()->subDays(count($transactions) - $i),
            ]);
        }

        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@securebank.com',
            'password' => Hash::make('password'),
            'phone' => '+1 (555) 999-0000',
            'address' => '456 Wall Street, New York, NY 10005',
            'date_of_birth' => '1985-01-01',
            'ssn_last_four' => '0001',
        ]);

        $this->call(BankingExperienceSeeder::class);
    }
}
