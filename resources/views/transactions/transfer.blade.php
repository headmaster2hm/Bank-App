@extends('layouts.banking')
@section('title', 'Transfer Money')

@section('content')
<div class="fade-in max-w-xl">
    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="text-sm text-brand-600 hover:text-brand-700 inline-flex items-center gap-1 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Dashboard
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Transfer Money</h1>
        <p class="text-gray-500 text-sm mt-1">Send money between your accounts or to another account</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('transfer') }}">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="from_account_id" class="block text-sm font-medium text-gray-700 mb-1">From Account</label>
                    <select name="from_account_id" id="from_account_id" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none @error('from_account_id') border-red-300 @enderror">
                        <option value="">Select source account</option>
                        @foreach($accounts as $account)
                            @if($account->status === 'active')
                                <option value="{{ $account->id }}" {{ old('from_account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->account_name }} ({{ $account->maskedNumber() }}) — ${{ number_format($account->balance, 2) }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('from_account_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-center">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    </div>
                </div>

                <div>
                    <label for="to_account_number" class="block text-sm font-medium text-gray-700 mb-1">To Account Number</label>
                    <input type="text" name="to_account_number" id="to_account_number" value="{{ old('to_account_number') }}" required
                        placeholder="Enter 12-digit account number"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('to_account_number') border-red-300 @enderror">
                    <p class="text-xs text-gray-400 mt-1">Enter the full account number of the recipient</p>
                    @error('to_account_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-lg">$</span>
                        <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="0.01" step="0.01"
                            placeholder="0.00"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-lg font-semibold focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('amount') border-red-300 @enderror">
                    </div>
                    @error('amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Memo (Optional)</label>
                    <input type="text" name="description" id="description" value="{{ old('description') }}"
                        placeholder="What's this transfer for?"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold text-center hover:bg-gray-200 transition">Cancel</a>
                <button type="submit" class="flex-1 bg-brand-600 text-white py-3 rounded-xl font-semibold hover:bg-brand-700 transition">
                    Send Transfer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
