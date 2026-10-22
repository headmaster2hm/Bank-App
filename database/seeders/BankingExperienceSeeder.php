<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Biller;
use App\Models\BankNotification;
use App\Models\Card;
use App\Models\CreditProfile;
use App\Models\Document;
use App\Models\InvestmentHolding;
use App\Models\Loan;
use App\Models\Message;
use App\Models\MessageThread;
use App\Models\SavingsGoal;
use App\Models\ScheduledTransfer;
use App\Models\SecurityEvent;
use App\Models\Transaction;
use App\Models\TrustedDevice;
use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Database\Seeder;

class BankingExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'demo@securebank.com')->firstOrFail();

        $checking = Account::where('user_id', $user->id)->where('account_type', 'checking')->firstOrFail();
        $savings = Account::where('user_id', $user->id)->where('account_type', 'savings')->firstOrFail();

        $this->seedHistory($checking, $savings);
        $this->seedPreferences($user);
        $this->seedCredit($user);
        $this->seedCards($user, $checking);
        $this->seedLoans($user);
        $this->seedGoals($user, $savings);
        $this->seedBillers($user, $checking);
        $this->seedScheduledTransfers($user, $checking, $savings);
        $this->seedDocuments($user, $checking, $savings);
        $this->seedNotifications($user);
        $this->seedSecurity($user);
        $this->seedMessages($user);
        $this->seedInvestments($user);
    }

    /**
     * Additional history so spending analysis and cash flow have real months to report on.
     */
    private function seedHistory(Account $checking, Account $savings): void
    {
        $now = now();
        $rows = [];
        $reference = 90000;

        $spending = [
            'housing' => [['Rent Payment', 'Apartment Complex', 1200.00]],
            'grocery' => [
                ['Whole Foods Market', 'Whole Foods', 92.40],
                ['Trader Joes Grocery', 'Trader Joes', 74.18],
                ['Whole Foods Market', 'Whole Foods', 108.62],
                ['Corner Market', 'Corner Market', 41.25],
            ],
            'utilities' => [
                ['Electric Company Bill', 'ConEdison', 156.00],
                ['Water Utility Payment', 'City Water', 48.30],
                ['Internet Service Bill', 'FiberLink', 79.99],
                ['Electric Company Bill', 'ConEdison', 162.45],
            ],
            'transportation' => [
                ['Shell Gas Station', 'Shell', 45.50],
                ['Metro Transit Pass', 'City Transit', 132.00],
                ['Shell Gas Station', 'Shell', 51.80],
                ['Parking Garage', 'ParkSafe', 18.00],
            ],
            'dining' => [
                ['Starbucks Coffee', 'Starbucks', 23.45],
                ['Local Deli Lunch', 'Corner Deli', 16.80],
                ['Neighborhood Bistro', 'Bistro', 64.20],
                ['Pizzeria Night', 'Pizzeria', 47.50],
            ],
            'entertainment' => [
                ['Netflix Subscription', 'Netflix', 12.99],
                ['Cinema Tickets', 'Rialto Cinema', 34.00],
                ['Netflix Subscription', 'Netflix', 12.99],
                ['Concert Tickets', 'City Arena', 95.00],
            ],
            'health' => [
                ['Gym Membership', 'Planet Fitness', 55.00],
                ['Pharmacy Purchase', 'Walgreens', 28.75],
                ['Dental Visit Copay', 'Bright Dental', 85.00],
            ],
            'shopping' => [
                ['Apple Store Purchase', 'Apple', 299.00],
                ['Online Apparel Order', 'Everyday Store', 62.40],
                ['Home Supply Store', 'HomePro', 118.65],
            ],
        ];

        // The base seeder already populates the current month, so only the two
        // completed months are filled here. Seeding all three would double-count
        // the current month and make the month-over-month comparison meaningless.
        $spendScale = [
            2 => 0.86,
            1 => 0.94,
        ];

        foreach ($spendScale as $monthsAgo => $factor) {
            $monthStart = $now->copy()->subMonths((int) $monthsAgo)->startOfMonth();

            foreach ($spending as $category => $entries) {
                foreach ($entries as $entry) {
                    [$description, $merchant, $amount] = $entry;
                    $reference++;

                    $rows[] = [
                        'account_id' => $checking->id,
                        'type' => 'withdrawal',
                        'amount' => round($amount * $factor, 2),
                        'description' => $description.' · '.now()->subMonths((int) $monthsAgo)->format('M'),
                        'merchant' => $merchant,
                        'category' => $category,
                        'status' => 'completed',
                        'reference_number' => 'TXNHIST'.$reference,
                        'balance_after' => $checking->balance,
                        'created_at' => $monthStart->copy()->addDays(random_int(1, 26))->setTime(random_int(8, 20), 0),
                    ];
                }
            }

            $reference++;
            $rows[] = [
                'account_id' => $checking->id,
                'type' => 'deposit',
                'amount' => 5200.00,
                'description' => 'Direct Deposit - Salary',
                'merchant' => 'ACME Corp',
                'category' => 'income',
                'status' => 'completed',
                'reference_number' => 'TXNHIST'.$reference,
                'balance_after' => $checking->balance,
                'created_at' => $monthStart->copy()->addDays(1)->setTime(9, 0),
            ];

            $reference++;
            $rows[] = [
                'account_id' => $checking->id,
                'type' => 'deposit',
                'amount' => 840.00,
                'description' => 'Freelance Invoice Payment',
                'merchant' => 'Northwind Studio',
                'category' => 'income',
                'status' => 'completed',
                'reference_number' => 'TXNHIST'.$reference,
                'balance_after' => $checking->balance,
                'created_at' => $monthStart->copy()->addDays(18)->setTime(14, 30),
            ];
        }

        foreach ($rows as $row) {
            Transaction::firstOrCreate(['reference_number' => $row['reference_number']], $row);
        }

        $reference++;
        Transaction::firstOrCreate(['reference_number' => 'TXNHIST'.$reference], [
            'account_id' => $savings->id,
            'type' => 'deposit',
            'amount' => 97.40,
            'description' => 'Interest Payment',
            'category' => 'interest',
            'status' => 'completed',
            'reference_number' => 'TXNHIST'.$reference,
            'balance_after' => $savings->balance,
            'created_at' => $now->copy()->subDays(3)->setTime(12, 0),
        ]);
    }

    private function seedPreferences(User $user): void
    {
        UserPreference::updateOrCreate(
            ['user_id' => $user->id],
            [
                'balances_visible_by_default' => true,
                'two_factor_enabled' => true,
                'login_alerts' => true,
                'payment_alerts' => true,
                'promotional_emails' => false,
                'paperless_statements' => true,
                'statement_format' => 'pdf',
                'time_zone' => 'America/New_York',
            ]
        );
    }

    private function seedCredit(User $user): void
    {
        CreditProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'score' => 748,
                'range_label' => 'Good',
                'previous_score' => 734,
                'month_over_month_change' => 14,
                'updated_at_date' => now()->subDays(2),
            ]
        );
    }

    private function seedCards(User $user, Account $checking): void
    {
        Card::updateOrCreate(
            ['user_id' => $user->id, 'last_four' => '4417'],
            [
                'account_id' => $checking->id,
                'card_type' => 'debit',
                'card_name' => 'Everyday Debit',
                'card_brand' => 'SecureBank',
                'expiry_month' => '09',
                'expiry_year' => '2029',
                'status' => 'active',
                'frozen' => false,
                'online_purchases' => true,
                'international_purchases' => false,
                'atm_withdrawals' => true,
                'contactless' => true,
                'current_balance' => 0,
            ]
        );

        Card::updateOrCreate(
            ['user_id' => $user->id, 'last_four' => '8802'],
            [
                'account_id' => $checking->id,
                'card_type' => 'credit',
                'card_name' => 'Rewards Credit',
                'card_brand' => 'SecureBank',
                'expiry_month' => '03',
                'expiry_year' => '2028',
                'status' => 'active',
                'frozen' => false,
                'online_purchases' => true,
                'international_purchases' => true,
                'atm_withdrawals' => true,
                'contactless' => true,
                'credit_limit' => 15000.00,
                'current_balance' => 3240.75,
                'minimum_payment' => 108.03,
                'payment_due_day' => 14,
            ]
        );
    }

    private function seedLoans(User $user): void
    {
        Loan::updateOrCreate(
            ['reference_number' => 'SB-LN-204918'],
            [
                'user_id' => $user->id,
                'loan_type' => 'auto',
                'loan_name' => 'Auto Loan',
                'original_amount' => 28000.00,
                'balance' => 16240.00,
                'interest_rate' => 4.90,
                'next_payment_amount' => 455.32,
                'next_payment_date' => now()->addDays(9),
                'term_months' => 60,
                'payments_remaining' => 41,
                'first_payment_date' => now()->subMonths(19)->startOfMonth(),
                'status' => 'active',
            ]
        );

        Loan::updateOrCreate(
            ['reference_number' => 'SB-LN-773102'],
            [
                'user_id' => $user->id,
                'loan_type' => 'personal',
                'loan_name' => 'Personal Loan',
                'original_amount' => 12000.00,
                'balance' => 3450.00,
                'interest_rate' => 6.25,
                'next_payment_amount' => 219.44,
                'next_payment_date' => now()->addDays(16),
                'term_months' => 60,
                'payments_remaining' => 18,
                'first_payment_date' => now()->subMonths(42)->startOfMonth(),
                'status' => 'active',
            ]
        );
    }

    private function seedGoals(User $user, Account $savings): void
    {
        $goals = [
            ['Emergency Fund', 'Six months of expenses', 20000.00, 13400.00, 6],
            ['New Vehicle', 'Down payment for replacement car', 15000.00, 8250.00, 14],
            ['Home Deposit', 'Down payment and closing costs', 60000.00, 18200.00, 30],
        ];

        foreach ($goals as [$name, $purpose, $target, $current, $months]) {
            SavingsGoal::updateOrCreate(
                ['user_id' => $user->id, 'name' => $name],
                [
                    'account_id' => $savings->id,
                    'purpose' => $purpose,
                    'target_amount' => $target,
                    'current_amount' => $current,
                    'target_date' => now()->addMonths($months),
                    'status' => 'active',
                ]
            );
        }
    }

    private function seedBillers(User $user, Account $checking): void
    {
        $billers = [
            ['Metro Electric', 'Utilities', 'EL-88213', 162.45, 4, false, null],
            ['FiberLink Internet', 'Utilities', 'FL-55190', 79.99, 9, true, 'monthly'],
            ['Harbor Property Mgmt', 'Housing', 'HP-12045', 1200.00, 2, true, 'monthly'],
            ['Auto Insurance Co', 'Insurance', 'AI-77301', 148.20, 21, false, null],
            ['Gymnasium Membership', 'Health', 'GM-40122', 55.00, 12, true, 'monthly'],
        ];

        foreach ($billers as [$name, $category, $reference, $amount, $dueInDays, $autopay, $frequency]) {
            Biller::updateOrCreate(
                ['user_id' => $user->id, 'name' => $name],
                [
                    'account_id' => $checking->id,
                    'category' => $category,
                    'account_reference' => $reference,
                    'amount_due' => $amount,
                    'due_date' => now()->addDays($dueInDays),
                    'autopay' => $autopay,
                    'autopay_frequency' => $frequency,
                    'status' => 'due',
                ]
            );
        }
    }

    private function seedScheduledTransfers(User $user, Account $checking, Account $savings): void
    {
        $transfers = [
            ['Weekly savings transfer', 200.00, 'weekly', 3],
            ['Monthly savings transfer', 1000.00, 'monthly', 11],
            ['Quarterly reserve transfer', 750.00, 'quarterly', 24],
        ];

        foreach ($transfers as [$description, $amount, $frequency, $nextRunInDays]) {
            ScheduledTransfer::updateOrCreate(
                ['user_id' => $user->id, 'description' => $description],
                [
                    'from_account_id' => $checking->id,
                    'to_account_id' => $savings->id,
                    'amount' => $amount,
                    'frequency' => $frequency,
                    'next_run_date' => now()->addDays($nextRunInDays),
                    'status' => 'active',
                    'last_run_at' => now()->subDays(7),
                ]
            );
        }
    }

    private function seedDocuments(User $user, Account $checking, Account $savings): void
    {
        $documents = [
            ['statement', 'Monthly checking statement', now()->subMonth()->format('F Y'), $checking, 3],
            ['statement', 'Monthly checking statement', now()->subMonths(2)->format('F Y'), $checking, 34],
            ['statement', 'Monthly savings statement', now()->subMonth()->format('F Y'), $savings, 3],
            ['statement', 'Monthly savings statement', now()->subMonths(2)->format('F Y'), $savings, 34],
            ['tax', 'Annual consolidated tax summary', now()->subMonths(2)->format('Y'), null, 34],
            ['tax', 'Interest earned summary', now()->subMonths(2)->format('Y'), $savings, 34],
            ['loan', 'Auto loan agreement', null, null, 300],
            ['loan', 'Personal loan disclosure', null, null, 300],
            ['card', 'Rewards credit card terms', null, null, 240],
            ['notice', 'Statement delivery preference notice', now()->subDays(12)->format('F j, Y'), null, 12],
            ['notice', 'Account agreement summary', now()->subMonths(3)->format('F j, Y'), null, 96],
            ['agreement', 'Deposit account disclosure', now()->subMonths(6)->format('F j, Y'), null, 190],
        ];

        foreach ($documents as [$type, $title, $period, $account, $daysAgo]) {
            Document::updateOrCreate(
                ['user_id' => $user->id, 'title' => $title, 'period_label' => $period],
                [
                    'account_id' => $account?->id,
                    'document_type' => $type,
                    'document_date' => now()->subDays($daysAgo),
                    'file_size_label' => 'PDF · '.(120 + random_int(10, 380)).' KB',
                    'status' => 'available',
                ]
            );
        }
    }

    private function seedNotifications(User $user): void
    {
        $notifications = [
            ['security', 'New sign-in from a recognised device', 'You signed in to online banking from Windows on Chrome in New York, NY. If this was not you, secure your account now.', 'Review activity', route('security.index'), 0, 2],
            ['payment', 'Auto loan payment scheduled', 'A payment of $455.32 is scheduled for your Auto Loan. It will be withdrawn from Premium Checking.', 'View loan', route('loans.index'), 1, 9],
            ['card', 'Your Rewards Credit statement is ready', 'Your statement for this billing period is available to view and download.', 'View statement', route('documents.index'), 2, 26],
            ['account', 'Direct deposit received', 'Your salary deposit of $5,200.00 has been posted to Premium Checking.', null, null, 1, 4],
            ['system', 'Two-step verification enabled', 'Two-step verification is now protecting your account.', 'Security settings', route('security.index'), 3, 21],
            ['payment', 'Upcoming bill in 4 days', 'Metro Electric has $162.45 due soon. Autopay is off for this biller.', 'Pay bill', route('billers.index'), 4, 30],
        ];

        foreach ($notifications as [$category, $title, $body, $actionLabel, $actionUrl, $daysAgo, $hoursAgo]) {
            BankNotification::updateOrCreate(
                ['user_id' => $user->id, 'title' => $title],
                [
                    'category' => $category,
                    'body' => $body,
                    'action_label' => $actionLabel,
                    'action_url' => $actionUrl,
                    'read_at' => $daysAgo >= 4 ? now()->subDays($daysAgo)->subHours(1) : null,
                    'created_at' => now()->subDays($daysAgo)->subHours($hoursAgo),
                ]
            );
        }
    }

    private function seedSecurity(User $user): void
    {
        $devices = [
            ['This browser', 'desktop', 'New York, NY', now()->subMinutes(4), now()->subMonths(2)],
            ['iPhone 15', 'mobile', 'New York, NY', now()->subDays(1), now()->subMonths(5)],
            ['Work MacBook', 'desktop', 'New York, NY', now()->subDays(9), now()->subMonths(3)],
        ];

        foreach ($devices as [$name, $type, $location, $lastUsed, $trusted]) {
            TrustedDevice::updateOrCreate(
                ['user_id' => $user->id, 'device_name' => $name],
                [
                    'device_type' => $type,
                    'location' => $location,
                    'last_used_at' => $lastUsed,
                    'trusted_at' => $trusted,
                ]
            );
        }

        $events = [
            ['login', 'Signed in successfully', 'New York, NY', '198.51.100.24', 'This browser', false, 0, 4],
            ['transfer', 'Transfer of $1,000.00 submitted', 'New York, NY', '198.51.100.24', 'This browser', false, 2, 30],
            ['card_unfrozen', 'Rewards Credit card unfrozen', 'New York, NY', '198.51.100.24', 'This browser', false, 6, 20],
            ['card_frozen', 'Everyday Debit card frozen', 'New York, NY', '198.51.100.24', 'iPhone 15', false, 6, 26],
            ['password_change', 'Password changed', 'New York, NY', '198.51.100.24', 'This browser', false, 21, 10],
            ['failed_login', 'Failed sign-in attempt', 'Unknown location', '203.0.113.77', 'Unknown device', true, 27, 40],
        ];

        foreach ($events as [$type, $title, $location, $ip, $device, $suspicious, $daysAgo, $hoursAgo]) {
            SecurityEvent::updateOrCreate(
                ['user_id' => $user->id, 'event_type' => $type, 'title' => $title],
                [
                    'location' => $location,
                    'ip_address' => $ip,
                    'device_name' => $device,
                    'is_suspicious' => $suspicious,
                    'occurred_at' => now()->subDays($daysAgo)->subHours($hoursAgo),
                ]
            );
        }
    }

    private function seedMessages(User $user): void
    {
        $open = MessageThread::updateOrCreate(
            ['user_id' => $user->id, 'subject' => 'Question about auto loan payoff amount'],
            ['category' => 'loans', 'status' => 'open', 'last_message_at' => now()->subDays(1)]
        );

        Message::updateOrCreate(
            ['message_thread_id' => $open->id, 'sent_at' => now()->subDays(2)->setTime(10, 15)],
            [
                'sender_type' => 'customer',
                'body' => 'I would like a current payoff figure for my auto loan, including the good-through date. Thank you.',
            ]
        );

        Message::updateOrCreate(
            ['message_thread_id' => $open->id, 'sent_at' => now()->subDays(1)->setTime(9, 40)],
            [
                'sender_type' => 'agent',
                'body' => 'Thank you for reaching out. A payoff statement is now available in your Documents section. It stays valid for ten days, so please download it if you plan to make the payment.',
            ]
        );

        $closed = MessageThread::updateOrCreate(
            ['user_id' => $user->id, 'subject' => 'Update contact phone number'],
            ['category' => 'profile', 'status' => 'closed', 'last_message_at' => now()->subDays(12)]
        );

        Message::updateOrCreate(
            ['message_thread_id' => $closed->id, 'sent_at' => now()->subDays(13)->setTime(15, 5)],
            ['sender_type' => 'customer', 'body' => 'Please update the phone number on my profile.'],
        );

        Message::updateOrCreate(
            ['message_thread_id' => $closed->id, 'sent_at' => now()->subDays(12)->setTime(11, 0)],
            ['sender_type' => 'agent', 'body' => 'Your phone number has been updated. Closing this request.'],
        );
    }

    private function seedInvestments(User $user): void
    {
        $holdings = [
            ['VTI', 'Vanguard Total Stock Market ETF', 'ETF', 42.0, 232.10, 268.44],
            ['VXUS', 'Vanguard Total International Stock ETF', 'ETF', 88.0, 54.20, 61.87],
            ['BND', 'Vanguard Total Bond Market ETF', 'ETF', 120.0, 72.60, 74.05],
            ['AAPL', 'Apple Inc.', 'Stock', 15.0, 178.30, 226.11],
        ];

        foreach ($holdings as [$symbol, $name, $class, $quantity, $purchase, $market]) {
            InvestmentHolding::updateOrCreate(
                ['user_id' => $user->id, 'symbol' => $symbol],
                [
                    'name' => $name,
                    'asset_class' => $class,
                    'quantity' => $quantity,
                    'purchase_price' => $purchase,
                    'market_price' => $market,
                ]
            );
        }
    }
}
