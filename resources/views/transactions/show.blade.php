@extends('layouts.banking')
@section('title', 'Transaction Details')

@section('content')
<div class="fade-in max-w-xl">
    <div class="mb-8">
        <a href="{{ route('transactions.index') }}" class="text-sm text-brand-600 hover:text-brand-700 inline-flex items-center gap-1 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Transactions
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Transaction Details</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="p-6 text-center border-b border-gray-100">
            <div class="w-14 h-14 {{ $transaction->isCredit() ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center mx-auto mb-3">
                @if($transaction->isCredit())
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                @else
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                @endif
            </div>
            <p class="text-sm text-gray-500">{{ $transaction->isCredit() ? 'Received' : 'Sent' }}</p>
            <p class="text-3xl font-bold {{ $transaction->isCredit() ? 'text-green-600' : 'text-red-600' }} mt-1">
                {{ $transaction->isCredit() ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
            </p>
        </div>

        <div class="p-6 space-y-4">
            <div class="flex justify-between py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">Status</span>
                <span class="text-sm font-medium text-green-600">{{ ucfirst($transaction->status) }}</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">Type</span>
                <span class="text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">Date</span>
                <span class="text-sm font-medium text-gray-900">{{ $transaction->created_at->format('F d, Y \a\t g:i A') }}</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">Account</span>
                <span class="text-sm font-medium text-gray-900">{{ $transaction->account->account_name }} ({{ $transaction->account->maskedNumber() }})</span>
            </div>
            @if($transaction->relatedAccount)
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">{{ $transaction->isCredit() ? 'From' : 'To' }}</span>
                    <span class="text-sm font-medium text-gray-900">{{ $transaction->relatedAccount->account_name }} ({{ $transaction->relatedAccount->maskedNumber() }})</span>
                </div>
            @endif
            <div class="flex justify-between py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">Description</span>
                <span class="text-sm font-medium text-gray-900 text-right">{{ $transaction->description }}</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">Reference</span>
                <span class="text-sm font-mono text-gray-900">{{ $transaction->reference_number }}</span>
            </div>
            <div class="flex justify-between py-2">
                <span class="text-sm text-gray-500">Balance After</span>
                <span class="text-sm font-bold text-gray-900">${{ number_format($transaction->balance_after, 2) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
