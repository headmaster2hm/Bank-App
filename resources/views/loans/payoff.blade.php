@extends('layouts.banking')

@section('title', 'Payoff quote')

@section('content')
    <x-page-header
        title="Payoff quote"
        :subtitle="'For ' . $loan->loan_name . ' · good through ' . $goodThrough"
        :back="route('loans.show', $loan)"
        back-label="Back to loan"
    />

    <div class="grid gap-5 lg:grid-cols-2">
        <x-panel title="Amount to pay off">
            <div class="p-5">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total payoff</p>
                <p class="mt-1.5 text-3xl font-semibold tracking-tight tabular-nums text-slate-900" data-balance-sensitive>
                    $<x-money :amount="$payoffAmount" :show-sign="false" />
                </p>

                <dl class="mt-5 space-y-3 border-t border-slate-200 pt-4 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Principal balance</dt>
                        <dd class="font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                            $<x-money :amount="$loan->balance" :show-sign="false" />
                        </dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Interest through {{ $goodThrough }}</dt>
                        <dd class="font-semibold text-slate-500">Calculated at close</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Good through</dt>
                        <dd class="font-semibold text-slate-900">{{ $goodThrough }}</dd>
                    </div>
                </dl>

                <a href="{{ route('loans.payment', $loan) }}"
                   class="mt-5 inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-brand-700 px-3 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                    Proceed to payment
                </a>
            </div>
        </x-panel>

        <x-panel title="About this demonstration quote">
            <div class="space-y-3 p-5 text-sm text-slate-600">
                <p>This is a prototype payoff quote calculated from sample balance, rate, and payment values.</p>
                <p>The quote is illustrative only. It is not a binding figure, and no payoff is actually processed.</p>
                <p>Real payoff terms such as quote validity, interest accrual, prepayment penalties, and payoff
                    processing would be disclosed here before launch.</p>
            </div>
        </x-panel>
    </div>
@endsection
