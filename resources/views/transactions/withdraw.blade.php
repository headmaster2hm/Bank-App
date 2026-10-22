@extends('layouts.banking')
@section('title', 'Withdraw Funds')

@section('content')
<div class="fade-in max-w-xl">
    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="text-sm text-brand-600 hover:text-brand-700 inline-flex items-center gap-1 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Dashboard
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Withdraw Funds</h1>
        <p class="text-gray-500 text-sm mt-1">Withdraw money from your account</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('withdraw') }}">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="account_id" class="block text-sm font-medium text-gray-700 mb-1">Withdraw From</label>
                    <select name="account_id" id="account_id" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none @error('account_id') border-red-300 @enderror">
                        <option value="">Select account</option>
                        @foreach($accounts as $account)
                            @if($account->status === 'active' && $account->balance > 0)
                                <option value="{{ $account->id }}" data-balance="{{ $account->balance }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
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
                        <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="0.01" step="0.01"
                            placeholder="0.00"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-lg font-semibold focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition @error('amount') border-red-300 @enderror">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Available: <span id="available-balance" class="font-medium text-gray-600">-</span></p>
                    @error('amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                    <input type="text" name="description" id="description" value="{{ old('description') }}"
                        placeholder="e.g., ATM withdrawal, Cash"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold text-center hover:bg-gray-200 transition">Cancel</a>
                <button type="submit" class="flex-1 bg-red-600 text-white py-3 rounded-xl font-semibold hover:bg-red-700 transition">
                    Confirm Withdrawal
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('account_id').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const balance = option.getAttribute('data-balance');
        document.getElementById('available-balance').textContent = balance ? '$' + parseFloat(balance).toLocaleString('en-US', {minimumFractionDigits: 2}) : '-';
    });
</script>
@endpush
@endsection
