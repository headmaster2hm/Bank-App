@extends('layouts.banking')

@section('title', $loan->loan_name)

@section('content')
    <x-page-header
        :title="$loan->loan_name"
        :subtitle="'Reference ' . $loan->reference_number"
        :back="route('loans.index')"
        back-label="All loans"
    >
        <x-slot:actions>
            @if($loan->isActive())
                <a href="{{ route('loans.payment', $loan) }}"
                   class="inline-flex items-center gap-1.5 rounded-lg bg-brand-700 px-3 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                    Make a payment
                </a>
                <a href="{{ route('loans.payoff', $loan) }}"
                   class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                    Payoff quote
                </a>
            @endif
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.3fr)]">
        <div class="space-y-5">
            <x-panel title="Balance">
                <div class="p-5">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Remaining balance</p>
                    <p class="mt-1.5 text-3xl font-semibold tracking-tight tabular-nums text-slate-900" data-balance-sensitive>
                        $<x-money :amount="$loan->balance" :show-sign="false" />
                    </p>

                    <div class="mt-5">
                        <x-progress
                            :value="$loan->original_amount - $loan->balance"
                            :max="$loan->original_amount"
                            :label="$loan->progressPercentage() . '% repaid'"
                            tone="brand"
                            size="lg"
                        />
                    </div>

                    <dl class="mt-5 space-y-3 border-t border-slate-200 pt-4 text-sm">
                        <div class="flex items-center justify-between gap-3">
                            <dt class="text-slate-500">Original amount</dt>
                            <dd class="font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                                $<x-money :amount="$loan->original_amount" :show-sign="false" />
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <dt class="text-slate-500">Repaid to date</dt>
                            <dd class="font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                                $<x-money :amount="$loan->original_amount - $loan->balance" :show-sign="false" />
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <dt class="text-slate-500">Interest rate</dt>
                            <dd class="font-semibold tabular-nums text-slate-900">
                                {{ rtrim(rtrim(number_format((float) $loan->interest_rate, 2), '0'), '.') }}% APR
                            </dd>
                        </div>
                    </dl>
                </div>
            </x-panel>

            <x-panel title="Next payment">
                <div class="p-5">
                    <p class="text-3xl font-semibold tracking-tight tabular-nums text-slate-900" data-balance-sensitive>
                        $<x-money :amount="$loan->next_payment_amount" :show-sign="false" />
                    </p>
                    <p class="mt-1.5 text-sm text-slate-600">
                        Due {{ $loan->next_payment_date->isoFormat('l, F j, Y') }}
                        @if($loan->daysUntilPayment() >= 0)
                            <span class="text-slate-500"> ({{ $loan->daysUntilPayment() }} days)</span>
                        @endif
                    </p>

                    <dl class="mt-4 space-y-3 border-t border-slate-200 pt-4 text-sm">
                        <div class="flex items-center justify-between gap-3">
                            <dt class="text-slate-500">Payments remaining</dt>
                            <dd class="font-semibold text-slate-900">{{ $loan->payments_remaining }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <dt class="text-slate-500">Estimated interest left</dt>
                            <dd class="font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                                $<x-money :amount="$loan->remainingInterest()" :show-sign="false" />
                            </dd>
                        </div>
                    </dl>

                    @if($loan->isActive())
                        <a href="{{ route('loans.payment', $loan) }}"
                           class="mt-4 inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-brand-700 px-3 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                            Pay this loan
                        </a>
                    @endif
                </div>
            </x-panel>
        </div>

        <x-panel title="Payment history" description="Recent payments applied to this loan">
            @if($paymentHistory->isNotEmpty())
                <div class="divide-y divide-slate-100 p-2">
                    @foreach($paymentHistory as $payment)
                        <x-transaction-row :transaction="$payment" />
                    @endforeach
                </div>
            @else
                <div class="p-5">
                    <x-empty-state
                        icon="receipt"
                        title="No payments recorded"
                        description="Payments made from online banking will appear here."
                        compact
                    />
                </div>
            @endif
        </x-panel>
    </div>
@endsection
