<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Biller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BillerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $billers = $user->billers()->orderBy('due_date')->get();

        return view('billers.index', [
            'billers' => $billers,
            'totalDue' => (float) $billers->where('status', 'due')->sum('amount_due'),
            'autopayCount' => $billers->where('autopay', true)->count(),
            'unreadCount' => $user->bankNotifications()->unread()->count(),
        ]);
    }

    public function create()
    {
        return view('billers.create', [
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
            'name' => ['required', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:60'],
            'account_reference' => ['nullable', 'string', 'max:60'],
            'amount_due' => ['required', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
            'account_id' => ['nullable', 'exists:accounts,id'],
            'autopay' => ['nullable', 'boolean'],
            'autopay_frequency' => ['nullable', 'in:monthly'],
        ]);

        $account = null;

        if (! empty($data['account_id'])) {
            $account = Account::where('user_id', Auth::id())->findOrFail($data['account_id']);
        }

        Biller::create([
            'user_id' => Auth::id(),
            'account_id' => $account?->id,
            'name' => $data['name'],
            'category' => $data['category'] ?? null,
            'account_reference' => $data['account_reference'] ?? null,
            'amount_due' => $data['amount_due'],
            'due_date' => $data['due_date'],
            'autopay' => $request->boolean('autopay'),
            'autopay_frequency' => $request->boolean('autopay') ? ($data['autopay_frequency'] ?? 'monthly') : null,
            'status' => 'due',
        ]);

        return redirect()->route('billers.index')->with('success', $data['name'] . ' was added to your billers.');
    }

    public function show(Biller $biller)
    {
        $this->authorizeBiller($biller);

        return view('billers.show', [
            'biller' => $biller,
            'history' => $biller->account_id
                ? Transaction::where('account_id', $biller->account_id)
                    ->where('description', 'like', '%' . $biller->name . '%')
                    ->latest()
                    ->limit(6)
                    ->get()
                : collect(),
            'unreadCount' => Auth::user()->bankNotifications()->unread()->count(),
        ]);
    }

    public function pay(Request $request, Biller $biller)
    {
        $this->authorizeBiller($biller);

        if ($request->isMethod('get')) {
            return view('billers.pay', [
                'biller' => $biller,
                'accounts' => Account::where('user_id', Auth::id())
                    ->whereIn('account_type', ['checking', 'savings'])
                    ->where('status', 'active')
                    ->get(),
            ]);
        }

        $data = $request->validate([
            'account_id' => ['required', 'exists:accounts,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $account = Account::where('user_id', Auth::id())->findOrFail($data['account_id']);
        $amount = round((float) $data['amount'], 2);

        if ($amount > (float) $account->available_balance) {
            return back()->with('error', 'That account does not have enough available funds for this payment.');
        }

        DB::transaction(function () use ($biller, $account, $amount) {
            $account->decrement('balance', $amount);
            $account->decrement('available_balance', $amount);

            Transaction::create([
                'account_id' => $account->id,
                'type' => 'withdrawal',
                'amount' => $amount,
                'balance_after' => $account->balance,
                'description' => 'Bill payment - ' . $biller->name,
                'merchant' => $biller->name,
                'reference_number' => Transaction::generateReference(),
                'status' => 'completed',
                'category' => $biller->category ?? 'utilities',
            ]);

            $biller->update([
                'status' => 'paid',
                'amount_due' => 0,
                'due_date' => now()->addMonth()->startOfMonth(),
            ]);
        });

        return redirect()
            ->route('billers.index')
            ->with('success', 'Your payment to ' . $biller->name . ' was submitted.');
    }

    public function toggleAutopay(Biller $biller)
    {
        $this->authorizeBiller($biller);

        $enabling = ! $biller->autopay;

        $biller->update([
            'autopay' => $enabling,
            'autopay_frequency' => $enabling ? ($biller->autopay_frequency ?? 'monthly') : null,
        ]);

        return back()->with('success', $enabling
            ? 'Autopay is now on for ' . $biller->name . '.'
            : 'Autopay is now off for ' . $biller->name . '.');
    }

    public function unpay(Biller $biller)
    {
        $this->authorizeBiller($biller);

        if ($biller->status === 'due') {
            return back()->with('error', 'This bill has not been marked as paid yet.');
        }

        $biller->update(['status' => 'due', 'amount_due' => max(1, (float) $biller->amount_due)]);

        return back()->with('success', $biller->name . ' was moved back to your unpaid bills.');
    }

    public function destroy(Biller $biller)
    {
        $this->authorizeBiller($biller);

        $biller->delete();

        return redirect()->route('billers.index')->with('success', $biller->name . ' was removed.');
    }

    private function authorizeBiller(Biller $biller): void
    {
        abort_unless($biller->user_id === Auth::id(), 403);
    }
}
