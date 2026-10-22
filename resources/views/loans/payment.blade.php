@extends('layouts.banking')

@section('title', 'Pay ' . $loan->loan_name)

@section('content')
    <x-page-header
        title="Make a payment"
        :subtitle="'Apply a payment to ' . $loan->loan_name . '.'"
        :back="route('loans.show', $loan)"
        back-label="Back to loan"
    />

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)]">
        <x-panel title="Payment details">
            <form method="POST" action="{{ route('loans.payment', $loan) }}" class="space-y-5 p-5">
                @csrf

                <div>
                    <label for="amount" class="block text-sm font-medium text-slate-800">Amount</label>
                    <div class="mt-1.5 flex gap-2">
                        <div class="relative flex-1">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-500">$</span>
                            <input id="amount" name="amount" type="number" step="0.01" min="1" required
                                   value="{{ old('amount', number_format((float) $loan->next_payment_amount, 2, '.', '')) }}"
                                   class="w-full rounded-lg border border-slate-300 py-2 pl-7 pr-3 text-sm tabular-nums focus:border-brand-500 focus-ring"
                                   aria-describedby="amount-hint">
                        </div>
                        <button type="button" data-set-amount="{{ number_format((float) $loan->next_payment_amount, 2, '.', '') }}"
                                class="shrink-0 rounded-lg border border-slate-300 px-3 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                            Pay minimum
                        </button>
                        <button type="button" data-set-amount="{{ number_format((float) $loan->balance, 2, '.', '') }}"
                                class="shrink-0 rounded-lg border border-slate-300 px-3 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                            Pay off
                        </button>
                    </div>
                    <p id="amount-hint" class="mt-1.5 text-xs text-slate-500">
                        Next scheduled payment is $<span class="tabular-nums">{{ number_format((float) $loan->next_payment_amount, 2) }}</span>.
                    </p>
                </div>

                <div>
                    <label for="account_id" class="block text-sm font-medium text-slate-800">Pay from</label>
                    <select id="account_id" name="account_id" required
                            class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white py-2 text-sm focus:border-brand-500 focus-ring">
                        <option value="">Select an account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" @selected(old('account_id') == $account->id)>
                                {{ $account->account_name }} ({{ $account->maskedNumber() }}) — available $<span class="tabular-nums">{{ number_format((float) $account->available_balance, 2) }}</span>
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-4">
                    <a href="{{ route('loans.show', $loan) }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 focus-ring">
                        Cancel
                    </a>
                    <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                        Submit payment
                    </button>
                </div>
            </form>
        </x-panel>

        <x-panel title="What this prototype does">
            <div class="space-y-3 p-5 text-sm text-slate-600">
                <p>This is a demonstration. A payment moves money between your own SecureBank accounts and reduces the
                    displayed loan balance, but no lender is involved and no real loan is affected.</p>
                <p>Loan balances, rates, and payment schedules on this page are sample values created for the demonstration.</p>
                <p>Real servicing terms such as posting times, interest allocation, and payoff treatment would be
                    disclosed here before launch.</p>
            </div>
        </x-panel>
    </div>

    <script>
        document.querySelectorAll('[data-set-amount]').forEach(function (button) {
            button.addEventListener('click', function () {
                var field = document.getElementById('amount');
                if (field) { field.value = button.dataset.setAmount; }
            });
        });
    </script>
@endsection
