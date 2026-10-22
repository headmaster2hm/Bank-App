<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\SavingsGoal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SavingsGoalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $goals = $user->savingsGoals()->orderByRaw("CASE status WHEN 'active' THEN 1 ELSE 2 END")->get();

        return view('goals.index', [
            'goals' => $goals,
            'totalSaved' => (float) $goals->where('status', 'active')->sum('current_amount'),
            'totalTarget' => (float) $goals->where('status', 'active')->sum('target_amount'),
            'unreadCount' => $user->bankNotifications()->unread()->count(),
        ]);
    }

    public function create()
    {
        return view('goals.create', [
            'accounts' => Account::where('user_id', Auth::id())
                ->whereIn('account_type', ['checking', 'savings'])
                ->where('status', 'active')
                ->get(),
            'unreadCount' => Auth::user()->bankNotifications()->unread()->count(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'purpose' => ['nullable', 'string', 'max:160'],
            'target_amount' => ['required', 'numeric', 'min:1', 'max:9999999'],
            'current_amount' => ['nullable', 'numeric', 'min:0'],
            'target_date' => ['nullable', 'date', 'after:today'],
            'account_id' => ['nullable', 'exists:accounts,id'],
        ]);

        $account = null;

        if (! empty($data['account_id'])) {
            $account = Account::where('user_id', Auth::id())->findOrFail($data['account_id']);
        }

        SavingsGoal::create([
            'user_id' => Auth::id(),
            'account_id' => $account?->id,
            'name' => $data['name'],
            'purpose' => $data['purpose'] ?? null,
            'target_amount' => $data['target_amount'],
            'current_amount' => $data['current_amount'] ?? 0,
            'target_date' => $data['target_date'] ?? null,
            'status' => 'active',
        ]);

        return redirect()->route('goals.index')->with('success', 'Your savings goal was created.');
    }

    public function show(SavingsGoal $goal)
    {
        $this->authorizeGoal($goal);

        return view('goals.show', [
            'goal' => $goal,
            'accounts' => Account::where('user_id', Auth::id())
                ->whereIn('account_type', ['checking', 'savings'])
                ->where('status', 'active')
                ->get(),
            'contributions' => $goal->account_id
                ? Transaction::where('account_id', $goal->account_id)
                    ->where('description', 'like', '%' . $goal->name . '%')
                    ->latest()
                    ->limit(6)
                    ->get()
                : collect(),
            'unreadCount' => Auth::user()->bankNotifications()->unread()->count(),
        ]);
    }

    public function contribute(Request $request, SavingsGoal $goal)
    {
        $this->authorizeGoal($goal);

        $data = $request->validate([
            'account_id' => ['required', 'exists:accounts,id'],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $account = Account::where('user_id', Auth::id())->findOrFail($data['account_id']);
        $amount = round((float) $data['amount'], 2);

        if ($amount > (float) $account->available_balance) {
            return back()->with('error', 'That account does not have enough available funds for this contribution.');
        }

        DB::transaction(function () use ($goal, $account, $amount) {
            $account->decrement('balance', $amount);
            $account->decrement('available_balance', $amount);

            $newTotal = round((float) $goal->current_amount + $amount, 2);

            $goal->update([
                'current_amount' => $newTotal,
                'status' => $newTotal >= (float) $goal->target_amount ? 'complete' : 'active',
            ]);

            Transaction::create([
                'account_id' => $account->id,
                'type' => 'withdrawal',
                'amount' => $amount,
                'balance_after' => $account->balance,
                'description' => 'Contribution to ' . $goal->name,
                'reference_number' => Transaction::generateReference(),
                'status' => 'completed',
                'category' => 'transfer',
            ]);
        });

        return back()->with('success', 'Contribution of $' . number_format($amount, 2) . ' added to ' . $goal->name . '.');
    }

    public function cancel(SavingsGoal $goal)
    {
        $this->authorizeGoal($goal);

        $goal->update(['status' => 'cancelled']);

        return redirect()->route('goals.index')->with('success', $goal->name . ' was cancelled. Your saved funds stay in your account.');
    }

    private function authorizeGoal(SavingsGoal $goal): void
    {
        abort_unless($goal->user_id === Auth::id(), 403);
    }
}
