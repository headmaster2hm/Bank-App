@extends('layouts.banking')
@section('title', 'Deposit Funds')

@section('content')
<div class="fade-in max-w-xl">
    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="text-sm text-brand-600 hover:text-brand-700 inline-flex items-center gap-1 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Dashboard
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Deposit Funds</h1>
        <p class="text-gray-500 text-sm mt-1">Add funds to your account</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('deposit') }}">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="account_id" class="block text-sm font-medium text-gray-700 mb-1">Deposit To</label>
                    <select name="account_id" id="account_id" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none @error('account_id') border-red-300 @enderror">
                        <option value="">Select account</option>
                        @foreach($accounts as $account)
                            @if($account->status === 'active')
                                <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->account_name }} ({{ $account->maskedNumber() }}) — ${{ number_format($account->balance, 2) }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('account_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-lg">$</span>
                        <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="0.01" max="50000" step="0.01"
                            placeholder="0.00"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-lg font-semibold focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('amount') border-red-300 @enderror">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Maximum single deposit: $50,000.00</p>
                    @error('amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                    <input type="text" name="description" id="description" value="{{ old('description') }}"
                        placeholder="e.g., Paycheck, Gift, Cash deposit"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold text-center hover:bg-gray-200 transition">Cancel</a>
                <button type="submit" class="flex-1 bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700 transition">
                    Confirm Deposit
                </button>
            </div>
        </form>
    </div>

    <div class="mt-4 bg-blue-50 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="text-sm font-medium text-blue-800">Mobile Check Deposit</p>
                <p class="text-xs text-blue-600 mt-1">You can also deposit checks by mailing them to our processing center. Funds are typically available within 1-2 business days.</p>
            </div>
        </div>
    </div>
</div>
@endsection
