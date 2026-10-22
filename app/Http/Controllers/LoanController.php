<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Loan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('loans.index', [
            'loans' => $user->loans()->orderBy('status')->orderBy('next_payment_date')->get(),
            'totalBalance' => (float) $user->loans()->where('status', 'active')->sum('balance'),
            'monthlyPayment' => (float) $user->loans()->where('status', 'active')->sum('next_payment_amount'),
            'unreadCount' => $user->bankNotifications()->unread()->count(),
        ]);
    }

    public function show(Loan $loan)
    {
        $this->authorizeLoan($loan);

        return view('loans.show', [
            'loan' => $loan,
            'paymentHistory' => Transaction::whereHas('account', fn ($q) => $q->where('user_id', $loan->user_id))
                ->where('type', 'withdrawal')
                ->where('description', 'like', '%' . $loan->loan_name . '%')
                ->latest()
                ->limit(8)
                ->get(),
            'unreadCount' => Auth::user()->bankNotifications()->unread()->count(),
        ]);
    }

    public function payment(Request $request, Loan $loan)
    {
        $this->authorizeLoan($loan);

        $accounts = Account::where('user_id', $loan->user_id)
            ->whereIn('account_type', ['checking', 'savings'])
            ->where('status', 'active')
            ->get();

        if ($request->isMethod('get')) {
            return view('loans.payment', ['loan' => $loan, 'accounts' => $accounts]);
        }

        $data = $request->validate([
            'account_id' => ['required', 'exists:accounts,id'],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $account = Account::where('user_id', $loan->user_id)->findOrFail($data['account_id']);
        $amount = round((float) $data['amount'], 2);

        if ($amount > (float) $account->available_balance) {
            return back()->with('error', 'That account does not have enough available funds for this payment.');
        }

        DB::transaction(function () use ($loan, $account, $amount) {
            $account->decrement('balance', $amount);
            $account->decrement('available_balance', $amount);

            $balance = round((float) $loan->balance - $amount, 2);

            $loan->update([
                'balance' => max(0, $balance),
                'payments_remaining' => max(0, (int) $loan->payments_remaining - 1),
                'status' => $balance <= 0 ? 'paid_off' : 'active',
            ]);

            Transaction::create([
                'account_id' => $account->id,
                'type' => 'withdrawal',
                'amount' => $amount,
                'balance_after' => $account->balance,
                'description' => $loan->loan_name . ' Payment',
                'reference_number' => Transaction::generateReference(),
                'status' => 'completed',
                'category' => 'transfer',
            ]);
        });

        return redirect()
            ->route('loans.show', $loan)
            ->with('success', 'Your payment of $' . number_format($amount, 2) . ' was applied to ' . $loan->loan_name . '.');
    }

    public function payoff(Loan $loan)
    {
        $this->authorizeLoan($loan);

        return view('loans.payoff', [
            'loan' => $loan,
            'payoffAmount' => round((float) $loan->balance, 2),
            'goodThrough' => now()->addDays(10)->isoFormat('F j, Y'),
        ]);
    }

    private function authorizeLoan(Loan $loan): void
    {
        abort_unless($loan->user_id === Auth::id(), 403);
    }
}
