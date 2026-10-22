<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Biller;
use App\Models\Card;
use App\Models\InvestmentHolding;
use App\Models\Loan;
use App\Models\SavingsGoal;
use App\Models\ScheduledTransfer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

class DashboardSummary
{
    /**
     * Account categories drive sign, ordering, and copy across the dashboard.
     *
     * @return array<int, array{key: string, label: string, types: array<int, string>}>
     */
    public static function groupings(): array
    {
        return [
            ['key' => 'deposits', 'label' => 'Deposit accounts', 'types' => ['checking', 'savings', 'money_market']],
            ['key' => 'credit', 'label' => 'Credit', 'types' => ['credit']],
            ['key' => 'loans', 'label' => 'Loans', 'types' => ['mortgage']],
        ];
    }

    /**
     * Net worth treats borrowing as negative so a mortgage holder sees a real figure.
     */
    public static function netWorth(User $user, Collection $accounts): float
    {
        $assets = $accounts->whereIn('account_type', ['checking', 'savings', 'money_market'])->sum('balance');
        $liabilities = $accounts->whereIn('account_type', ['credit', 'mortgage'])->sum('balance');

        return (float) $assets - (float) $liabilities;
    }

    public static function availableCash(Collection $accounts): float
    {
        return (float) $accounts->whereIn('account_type', ['checking', 'savings', 'money_market'])
            ->sum('available_balance');
    }

    public static function totalCreditLimit(Collection $accounts): float
    {
        return (float) $accounts->whereIn('account_type', ['credit'])->sum('credit_limit');
    }

    public static function totalDebt(Collection $accounts): float
    {
        return (float) $accounts->whereIn('account_type', ['credit', 'mortgage'])->sum('balance');
    }

    public static function groupAccounts(Collection $accounts): array
    {
        $grouped = [];

        foreach (self::groupings() as $group) {
            $grouped[$group['key']] = [
                'label' => $group['label'],
                'accounts' => $accounts->whereIn('account_type', $group['types'])->values(),
            ];
        }

        return $grouped;
    }

    /**
     * Spending by category for the trailing month, largest first.
     *
     * @return array<int, array{category: string, total: float, percentage: float}>
     */
    public static function spendingByCategory(User $user, int $monthsBack = 0): array
    {
        $from = now()->subMonths($monthsBack)->startOfMonth();
        $to = now()->startOfMonth()->endOfMonth();

        $rows = Transaction::whereHas('account', fn ($q) => $q->where('user_id', $user->id))
            ->where('type', 'withdrawal')
            ->whereBetween('created_at', [$from, $to])
            ->whereNotNull('category')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $total = (float) $rows->sum('total');

        return $rows->map(function ($row) use ($total) {
            return [
                'category' => $row->category,
                'label' => self::categoryLabel($row->category),
                'total' => round((float) $row->total, 2),
                'percentage' => $total > 0 ? round(((float) $row->total / $total) * 100, 1) : 0.0,
            ];
        })->values()->all();
    }

    /**
     * Income versus outflows across a trailing window, for the cash-flow chart.
     *
     * @return array<int, array{label: string, income: float, outflow: float}>
     */
    public static function cashFlow(User $user, int $months = 3): array
    {
        $from = now()->subMonths($months - 1)->startOfMonth();

        $rows = Transaction::whereHas('account', fn ($q) => $q->where('user_id', $user->id))
            ->where('created_at', '>=', $from)
            ->get(['type', 'amount', 'created_at']);

        $buckets = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $month = now()->subMonths($i);

            $buckets[$month->format('Y-m')] = [
                'label' => $month->format('M'),
                'full_label' => $month->format('F Y'),
                'income' => 0.0,
                'outflow' => 0.0,
            ];
        }

        foreach ($rows as $row) {
            $key = $row->created_at->format('Y-m');

            if (! isset($buckets[$key])) {
                continue;
            }

            if (in_array($row->type, ['deposit', 'transfer_in', 'payment'], true)) {
                $buckets[$key]['income'] += (float) $row->amount;
            } elseif ($row->type === 'withdrawal' || $row->type === 'transfer_out') {
                $buckets[$key]['outflow'] += (float) $row->amount;
            }
        }

        foreach ($buckets as $key => $bucket) {
            $buckets[$key]['income'] = round($bucket['income'], 2);
            $buckets[$key]['outflow'] = round($bucket['outflow'], 2);
            $buckets[$key]['net'] = round($bucket['income'] - $bucket['outflow'], 2);
        }

        return array_values($buckets);
    }

    /**
     * Month-to-date spending compared with the same stretch of days last month.
     *
     * Comparing a partial month against a whole month would always look like a
     * drop, so both windows are clipped to the same elapsed-day count.
     *
     * @return array<int, array{category: string, label: string, current: float, previous: float, delta: float, direction: string}>
     */
    public static function spendingTrends(User $user): Collection
    {
        $elapsedDays = (int) now()->dayOfMonth;

        $current = collect(self::spendingBetween($user, now()->startOfMonth(), now()))->keyBy('category');
        $previous = collect(self::spendingBetween($user, now()->subMonth()->startOfMonth(), now()->subMonth()->startOfMonth()->copy()->addDays($elapsedDays - 1)->endOfDay()))->keyBy('category');

        return $current->map(function ($row) use ($previous) {
            $before = (float) ($previous[$row['category']]['total'] ?? 0);
            $delta = round($row['total'] - $before, 2);

            return [
                'category' => $row['category'],
                'label' => $row['label'],
                'current' => $row['total'],
                'previous' => $before,
                'delta' => $delta,
                'direction' => match (true) {
                    $delta > 0.01 => 'up',
                    $delta < -0.01 => 'down',
                    default => 'flat',
                },
            ];
        })->sortByDesc('current')->values();
    }

    /**
     * @return array<int, array{category: string, label: string, total: float}>
     */
    private static function spendingBetween(User $user, Carbon $from, Carbon $to): array
    {
        $rows = Transaction::whereHas('account', fn ($q) => $q->where('user_id', $user->id))
            ->where('type', 'withdrawal')
            ->whereBetween('created_at', [$from, $to])
            ->whereNotNull('category')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        return $rows->map(fn ($row) => [
            'category' => $row->category,
            'label' => self::categoryLabel($row->category),
            'total' => round((float) $row->total, 2),
        ])->values()->all();
    }

    public static function recentTransactions(User $user, int $limit = 8): Collection
    {
        return Transaction::whereHas('account', fn ($q) => $q->where('user_id', $user->id))
            ->with('account')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public static function upcomingBills(User $user, int $limit = 5): Collection
    {
        return Biller::where('user_id', $user->id)
            ->whereDate('due_date', '<=', now()->addDays(30))
            ->orderBy('due_date')
            ->limit($limit)
            ->get();
    }

    public static function upcomingTransfers(User $user, int $limit = 3): Collection
    {
        return ScheduledTransfer::where('user_id', $user->id)
            ->where('status', 'active')
            ->with(['fromAccount', 'toAccount'])
            ->orderBy('next_run_date')
            ->limit($limit)
            ->get();
    }

    public static function activeGoals(User $user, int $limit = 3): Collection
    {
        return SavingsGoal::where('user_id', $user->id)
            ->where('status', 'active')
            ->orderBy('target_date')
            ->limit($limit)
            ->get();
    }

    public static function activeLoans(User $user): Collection
    {
        return Loan::where('user_id', $user->id)->where('status', 'active')->get();
    }

    public static function creditCards(User $user): Collection
    {
        return Card::where('user_id', $user->id)->where('card_type', 'credit')->get();
    }

    public static function portfolioValue(User $user): float
    {
        return (float) InvestmentHolding::where('user_id', $user->id)
            ->get()
            ->sum(fn (InvestmentHolding $holding) => $holding->marketValue());
    }

    public static function accountIcon(Account $account): string
    {
        return match($account->account_type) {
            'checking' => 'banknotes',
            'savings' => 'archive',
            'credit' => 'card',
            'mortgage' => 'home',
            default => 'building',
        };
    }

    public static function categoryLabel(?string $category): string
    {
        return match($category) {
            'housing' => 'Housing',
            'grocery' => 'Groceries',
            'utilities' => 'Utilities',
            'transportation' => 'Transportation',
            'dining' => 'Dining',
            'entertainment' => 'Entertainment',
            'health' => 'Health',
            'shopping' => 'Shopping',
            'income' => 'Income',
            'interest' => 'Interest',
            'transfer' => 'Transfer',
            'fees' => 'Fees',
            default => $category ? ucfirst(str_replace('_', ' ', $category)) : 'Other',
        };
    }

    /**
     * Distinct category colours, reused by the donut and the legend.
     *
     * @return array<string, string>
     */
    public static function categoryColors(): array
    {
        return [
            'housing' => '#1F3A5F',
            'grocery' => '#2E6B5E',
            'utilities' => '#4A7C9B',
            'transportation' => '#6B7F9E',
            'dining' => '#A8763E',
            'entertainment' => '#8A5A7D',
            'health' => '#3F7F86',
            'shopping' => '#96604A',
            'other' => '#94A3B8',
        ];
    }
}
