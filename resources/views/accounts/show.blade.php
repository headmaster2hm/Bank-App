@extends('layouts.banking')
@section('title', $account->account_name)

@section('content')
<div class="fade-in">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('accounts.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $account->account_name }}</h1>
            <p class="text-gray-500 text-sm">{{ ucfirst($account->account_type) }} &middot; {{ $account->account_number }}</p>
        </div>
        @if($account->status === 'frozen')
            <span class="ml-auto text-sm bg-amber-100 text-amber-700 px-3 py-1 rounded-full font-medium">Account Frozen</span>
        @endif
    </div>

    {{-- Balance Card --}}
    <div class="gradient-bg rounded-2xl p-6 text-white mb-8">
        <p class="text-blue-200 text-sm">Available Balance</p>
        <p class="text-3xl font-bold mt-1">${{ number_format($account->available_balance, 2) }}</p>
        @if($account->account_type === 'savings')
            <p class="text-blue-200 text-xs mt-2">{{ $account->interest_rate }}% Annual Percentage Yield</p>
        @endif
    </div>

    <div class="flex gap-3 mb-8">
        <a href="{{ route('deposit') }}" class="bg-green-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-green-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Deposit
        </a>
        <a href="{{ route('withdraw') }}" class="bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
            Withdraw
        </a>
        <a href="{{ route('transfer') }}" class="bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            Transfer
        </a>
    </div>

    {{-- Transaction History --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-semibold text-gray-900">Transaction History</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Date</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Description</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Type</th>
                        <th class="text-right text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Amount</th>
                        <th class="text-right text-xs font-medium text-gray-500 uppercase tracking-wider px-5 py-3">Balance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $transaction->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-4">
                                <p class="text-sm font-medium text-gray-900">{{ $transaction->description }}</p>
                                @if($transaction->reference_number)
                                    <p class="text-xs text-gray-400">{{ $transaction->reference_number }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-xs px-2.5 py-1 rounded-full font-medium
                                    {{ $transaction->type === 'deposit' || $transaction->type === 'transfer_in' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $transaction->type === 'withdrawal' || $transaction->type === 'transfer_out' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $transaction->type === 'payment' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $transaction->type === 'fee' ? 'bg-gray-100 text-gray-700' : '' }}">
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
                            <td colspan="5" class="px-5 py-12 text-center">
                                <p class="text-gray-500 text-sm">No transactions for this account yet</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-100 px-5 py-3">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
