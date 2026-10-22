<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Auth::user()->accounts;
        return view('accounts.index', compact('accounts'));
    }

    public function show(Account $account)
    {
        if ($account->user_id !== Auth::id()) abort(403);

        $transactions = $account->transactions()->with('relatedAccount')->paginate(15);
        return view('accounts.show', compact('account', 'transactions'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_type' => 'required|in:checking,savings',
            'account_name' => 'required|string|max:100',
            'initial_deposit' => 'required|numeric|min:25',
        ]);

        Auth::user()->accounts()->create([
            'account_number' => Account::generateAccountNumber(),
            'account_type' => $validated['account_type'],
            'account_name' => $validated['account_name'],
            'balance' => $validated['initial_deposit'],
            'available_balance' => $validated['initial_deposit'],
            'interest_rate' => $validated['account_type'] === 'savings' ? 4.50 : 0,
        ]);

        return redirect()->route('accounts.index')->with('success', 'Account created successfully!');
    }

    public function update(Request $request, Account $account)
    {
        if ($account->user_id !== Auth::id()) abort(403);

        $account->update($request->validate([
            'account_name' => 'required|string|max:100',
        ]));

        return back()->with('success', 'Account updated!');
    }

    public function freeze(Account $account)
    {
        if ($account->user_id !== Auth::id()) abort(403);
        $account->update(['status' => 'frozen']);
        return back()->with('success', 'Account has been frozen.');
    }

    public function unfreeze(Account $account)
    {
        if ($account->user_id !== Auth::id()) abort(403);
        $account->update(['status' => 'active']);
        return back()->with('success', 'Account has been unfrozen.');
    }
}
