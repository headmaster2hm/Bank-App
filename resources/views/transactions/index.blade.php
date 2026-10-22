@extends('layouts.banking')
@section('title', 'Transactions')

@section('content')
<div class="fade-in">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Transactions</h1>
        <p class="text-gray-500 text-sm mt-1">View and search all your transactions</p>
    </div>

    {{-- Filters --}}
    <form method="GET" class="bg-white rounded-xl border border-gray-100 p-4 mb-6">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Description, ref..."
                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Account</label>
                <select name="account_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
                    <option value="">All Accounts</option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>
                            {{ $account->account_name }} ({{ $account->maskedNumber() }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Type</label>
                <select name="type" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
                    <option value="">All Types</option>
                    <option value="deposit" {{ request('type') === 'deposit' ? 'selected' : '' }}>Deposits</option>
                    <option value="withdrawal" {{ request('type') === 'withdrawal' ? 'selected' : '' }}>Withdrawals</option>
                    <option value="transfer_in" {{ request('type') === 'transfer_in' ? 'selected' : '' }}>Transfers In</option>
                    <option value="transfer_out" {{ request('type') === 'transfer_out' ? 'selected' : '' }}>Transfers Out</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
            </div>
            <div class="flex items-end gap-2">
                <div class="flex-1">
                    <label class="block text-xs font-medium text-gray-500 mb-1">To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
                </div>
                <button type="submit" class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700 transition">
                    Filter
                </button>
            </div>
        </div>
    </form>

    {{-- Transaction Table --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Date & Time</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Description</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Account</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Type</th>
                        <th class="text-right text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Amount</th>
                        <th class="text-right text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Balance After</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4 text-sm text-gray-500 whitespace-nowrap">
                                <span class="block">{{ $transaction->created_at->format('M d, Y') }}</span>
                                <span class="text-xs text-gray-400">{{ $transaction->created_at->format('g:i A') }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-sm font-medium text-gray-900">{{ $transaction->description }}</p>
                                <p class="text-xs text-gray-400">{{ $transaction->reference_number }}</p>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $transaction->account->account_name }}</td>
                            <td class="px-5 py-4">
                                <span class="text-xs px-2.5 py-1 rounded-full font-medium
                                    {{ in_array($transaction->type, ['deposit', 'transfer_in', 'payment']) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->type)) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm font-semibold text-right whitespace-nowrap {{ $transaction->isCredit() ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->isCredit() ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-900 text-right font-medium whitespace-nowrap">${{ number_format($transaction->balance_after, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <p class="text-gray-500 text-sm">No transactions found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-100 px-5 py-3">
            {{ $transactions->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
