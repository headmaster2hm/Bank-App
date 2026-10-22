<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Services\DashboardSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $preference = $user->preference;

        $accounts = Account::where('user_id', $user->id)
            ->orderByRaw("CASE account_type WHEN 'checking' THEN 1 WHEN 'savings' THEN 2 WHEN 'money_market' THEN 3 WHEN 'credit' THEN 4 ELSE 5 END")
            ->get();

        $spending = DashboardSummary::spendingByCategory($user, 0);
        $colors = DashboardSummary::categoryColors();

        $slices = collect($spending)->map(function (array $row) use ($colors) {
            $row['color'] = $colors[$row['category']] ?? $colors['other'];

            return $row;
        })->all();

        $cashFlow = DashboardSummary::cashFlow($user, 3);
        $trends = DashboardSummary::spendingTrends($user);

        $monthOutflow = collect($cashFlow)->last()['outflow'] ?? 0.0;
        $monthIncome = collect($cashFlow)->last()['income'] ?? 0.0;

        $goalTotal = $user->savingsGoals()->where('status', 'active')->sum('target_amount');
        $goalSaved = $user->savingsGoals()->where('status', 'active')->sum('current_amount');

        return view('dashboard', [
            'accounts' => $accounts,
            'grouped' => DashboardSummary::groupAccounts($accounts),
            'netWorth' => DashboardSummary::netWorth($user, $accounts),
            'availableCash' => DashboardSummary::availableCash($accounts),
            'totalCreditLimit' => DashboardSummary::totalCreditLimit($accounts),
            'totalDebt' => DashboardSummary::totalDebt($accounts),
            'creditCards' => DashboardSummary::creditCards($user),
            'loans' => DashboardSummary::activeLoans($user),
            'recentTransactions' => DashboardSummary::recentTransactions($user, 8),
            'spending' => $slices,
            'spendingTotal' => $spending ? array_sum(array_column($slices, 'total')) : 0.0,
            'trends' => $trends,
            'cashFlow' => $cashFlow,
            'monthOutflow' => $monthOutflow,
            'monthIncome' => $monthIncome,
            'monthNet' => $monthIncome - $monthOutflow,
            'upcomingBills' => DashboardSummary::upcomingBills($user, 5),
            'upcomingTransfers' => DashboardSummary::upcomingTransfers($user, 3),
            'goals' => DashboardSummary::activeGoals($user, 3),
            'goalSaved' => (float) $goalSaved,
            'goalTotal' => (float) $goalTotal,
            'creditProfile' => $user->creditProfile,
            'preference' => $preference,
            'unreadCount' => $user->bankNotifications()->unread()->count(),
            'balancesVisibleDefault' => $user->preference?->balances_visible_by_default ?? true,
            'documents' => $user->documents()->where('document_type', 'statement')->latest('document_date')->limit(3)->get(),
        ]);
    }
}
