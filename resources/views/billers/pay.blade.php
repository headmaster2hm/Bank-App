@extends('layouts.banking')

@section('title', 'Pay ' . $biller->name)

@section('content')
    <x-page-header
        title="Pay bill"
        :subtitle="'Send a payment to ' . $biller->name . '.'"
        :back="route('billers.show', $biller)"
        back-label="Back to biller"
    />

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)]">
        <x-panel title="Payment details">
            <form method="POST" action="{{ route('billers.pay', $biller) }}" class="space-y-5 p-5">
                @csrf

                <div>
                    <label for="amount" class="block text-sm font-medium text-slate-800">Amount</label>
                    <div class="relative mt-1.5">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-500">$</span>
                        <input id="amount" name="amount" type="number" step="0.01" min="0.01" required
                               value="{{ old('amount', number_format((float) $biller->amount_due, 2, '.', '')) }}"
                               class="w-full rounded-lg border border-slate-300 py-2 pl-7 pr-3 text-sm tabular-nums focus:border-brand-500 focus-ring"
                               aria-describedby="amount-hint">
                    </div>
                    <p id="amount-hint" class="mt-1.5 text-xs text-slate-500">
                        Amount due is $<span class="tabular-nums">{{ number_format((float) $biller->amount_due, 2) }}</span>. Paying less leaves the bill open.
                    </p>
                </div>

                <div>
                    <label for="account_id" class="block text-sm font-medium text-slate-800">Pay from</label>
                    <select id="account_id" name="account_id" required
                            class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white py-2 text-sm focus:border-brand-500 focus-ring">
                        <option value="">Select an account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}"
                                    @selected(old('account_id') == $biller->account_id && $biller->account_id === $account->id)>
                                {{ $account->account_name }} ({{ $account->maskedNumber() }}) — available $<span class="tabular-nums">{{ number_format((float) $account->available_balance, 2) }}</span>
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-4">
                    <a href="{{ route('billers.show', $biller) }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 focus-ring">
                        Cancel
                    </a>
                    <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                        Submit payment
                    </button>
                </div>
            </form>
        </x-panel>

        <x-panel title="Check before you pay">
            <div class="space-y-3 p-5 text-sm text-slate-600">
                <p>Confirm the amount and the account you are paying from. Payments cannot be cancelled once submitted.</p>
                <p>If this biller has autopay on, paying manually now is safe. Autopay simply stays enabled for the next cycle.</p>
                <p>You will see the payment in your transaction history as soon as it posts.</p>
            </div>
        </x-panel>
    </div>
@endsection
