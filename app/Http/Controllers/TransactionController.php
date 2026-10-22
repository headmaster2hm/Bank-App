<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $accounts = Auth::user()->accounts;
        $accountIds = $accounts->pluck('id');

        $query = Transaction::whereIn('account_id', $accountIds)->with('account');

        if ($request->filled('account_id')) {
            $query->where('account_id', $request->account_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', "%{$request->search}%")
                  ->orWhere('reference_number', 'like', "%{$request->search}%")
                  ->orWhere('merchant', 'like', "%{$request->search}%");
            });
        }

        $transactions = $query->latest()->paginate(20);

        return view('transactions.index', compact('accounts', 'transactions'));
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->account->user_id !== Auth::id()) abort(403);
        return view('transactions.show', compact('transaction'));
    }

    public function transfer(Request $request)
    {
        $accounts = Auth::user()->accounts;

        if ($request->isMethod('get')) {
            return view('transactions.transfer', compact('accounts'));
        }

        $validated = $request->validate([
            'from_account_id' => 'required|exists:accounts,id',
            'to_account_number' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $fromAccount = Account::findOrFail($validated['from_account_id']);

            if ($fromAccount->user_id !== Auth::id()) {
                throw new \Exception('Unauthorized account access.');
            }

            if ($fromAccount->status !== 'active') {
                throw new \Exception('Source account is not active.');
            }

            if ($fromAccount->balance < $validated['amount']) {
                throw new \Exception('Insufficient funds.');
            }

            $toAccount = Account::where('account_number', $validated['to_account_number'])->first();

            if (!$toAccount) {
                throw new \Exception('Destination account not found.');
            }

            if ($toAccount->id === $fromAccount->id) {
                throw new \Exception('Cannot transfer to the same account.');
            }

            // Debit source
            $fromAccount->decrement('balance', $validated['amount']);
            $fromAccount->decrement('available_balance', $validated['amount']);

            Transaction::create([
                'account_id' => $fromAccount->id,
                'related_account_id' => $toAccount->id,
                'type' => 'transfer_out',
                'amount' => $validated['amount'],
                'balance_after' => $fromAccount->fresh()->balance,
                'description' => $validated['description'] ?? 'Transfer to ' . $toAccount->account_name,
                'reference_number' => Transaction::generateReference(),
                'status' => 'completed',
            ]);

            // Credit destination
            $toAccount->increment('balance', $validated['amount']);
            $toAccount->increment('available_balance', $validated['amount']);

            Transaction::create([
                'account_id' => $toAccount->id,
                'related_account_id' => $fromAccount->id,
                'type' => 'transfer_in',
                'amount' => $validated['amount'],
                'balance_after' => $toAccount->fresh()->balance,
                'description' => $validated['description'] ?? 'Transfer from ' . $fromAccount->account_name,
                'reference_number' => Transaction::generateReference(),
                'status' => 'completed',
            ]);

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Transfer completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function mobileDeposit()
    {
        $accounts = Auth::user()->accounts()->where('status', 'active')->get();

        return view('transactions.mobile-deposit', compact('accounts'));
    }

    public function deposit(Request $request)
    {
        $accounts = Auth::user()->accounts;

        if ($request->isMethod('get')) {
            return view('transactions.deposit', compact('accounts'));
        }

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01|max:50000',
            'description' => 'nullable|string|max:255',
        ]);

        $account = Account::findOrFail($validated['account_id']);

        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            $account->increment('balance', $validated['amount']);
            $account->increment('available_balance', $validated['amount']);

            Transaction::create([
                'account_id' => $account->id,
                'type' => 'deposit',
                'amount' => $validated['amount'],
                'balance_after' => $account->fresh()->balance,
                'description' => $validated['description'] ?? 'Cash Deposit',
                'reference_number' => Transaction::generateReference(),
                'status' => 'completed',
            ]);

            DB::commit();

            return redirect()->route('accounts.show', $account)->with('success', 'Deposit successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Deposit failed. Please try again.');
        }
    }

    public function withdraw(Request $request)
    {
        $accounts = Auth::user()->accounts;

        if ($request->isMethod('get')) {
            return view('transactions.withdraw', compact('accounts'));
        }

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
        ]);

        $account = Account::findOrFail($validated['account_id']);

        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        if ($account->balance < $validated['amount']) {
            return back()->withInput()->with('error', 'Insufficient funds.');
        }

        DB::beginTransaction();

        try {
            $account->decrement('balance', $validated['amount']);
            $account->decrement('available_balance', $validated['amount']);

            Transaction::create([
                'account_id' => $account->id,
                'type' => 'withdrawal',
                'amount' => $validated['amount'],
                'balance_after' => $account->fresh()->balance,
                'description' => $validated['description'] ?? 'Cash Withdrawal',
                'reference_number' => Transaction::generateReference(),
                'status' => 'completed',
            ]);

            DB::commit();

            return redirect()->route('accounts.show', $account)->with('success', 'Withdrawal successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Withdrawal failed. Please try again.');
        }
    }
}
