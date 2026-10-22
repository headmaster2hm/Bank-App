@extends('layouts.banking')
@section('title', 'Open New Account')

@section('content')
<div class="fade-in max-w-xl">
    <div class="mb-8">
        <a href="{{ route('accounts.index') }}" class="text-sm text-brand-600 hover:text-brand-700 inline-flex items-center gap-1 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Accounts
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Open a New Account</h1>
        <p class="text-gray-500 text-sm mt-1">Choose the account type that fits your needs</p>
    </div>

    <form method="POST" action="{{ route('accounts.store') }}">
        @csrf
        <div class="space-y-6">
            {{-- Account Type --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Account Type</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative">
                        <input type="radio" name="account_type" value="checking" class="peer sr-only" checked>
                        <div class="border-2 border-gray-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 rounded-xl p-5 cursor-pointer transition text-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4z"/></svg>
                            </div>
                            <p class="font-semibold text-gray-900">Checking</p>
                            <p class="text-xs text-gray-500 mt-1">Everyday banking with debit card access</p>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="account_type" value="savings" class="peer sr-only">
                        <div class="border-2 border-gray-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 rounded-xl p-5 cursor-pointer transition text-center">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                            </div>
                            <p class="font-semibold text-gray-900">Savings</p>
                            <p class="text-xs text-gray-500 mt-1">Earn 4.50% APY on your balance</p>
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label for="account_name" class="block text-sm font-medium text-gray-700 mb-1">Account Nickname</label>
                <input type="text" name="account_name" id="account_name" value="{{ old('account_name') }}" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition"
                    placeholder="e.g., Vacation Fund, Emergency Savings">
                @error('account_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="initial_deposit" class="block text-sm font-medium text-gray-700 mb-1">Initial Deposit</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                    <input type="number" name="initial_deposit" id="initial_deposit" value="{{ old('initial_deposit', 25) }}" required min="25" step="0.01"
                        class="w-full pl-8 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                </div>
                <p class="text-xs text-gray-400 mt-1">Minimum deposit: $25.00</p>
                @error('initial_deposit') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-brand-600 text-white py-3 rounded-xl font-semibold hover:bg-brand-700 transition shadow-sm">
                Open Account
            </button>
        </div>
    </form>
</div>
@endsection
