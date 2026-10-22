@extends('layouts.banking')

@section('title', 'Loans')

@section('content')
    <x-page-header
        title="Loans"
        subtitle="Balances, rates, and upcoming payments across your loans."
    />

    <div class="mb-5 grid gap-4 sm:grid-cols-3">
        <x-stat label="Total balance" :value="'$' . number_format($totalBalance, 2)" icon="mortgage" :blank="true" />
        <x-stat label="Monthly payments" :value="'$' . number_format($monthlyPayment, 2)" icon="calendar" :blank="true" />
        <x-stat :label="'Active loans'" :value="$loans->where('status', 'active')->count()" icon="document" />
    </div>

    @if($loans->isEmpty())
        <x-empty-state
            icon="mortgage"
            title="No loans on file"
            description="Loans you take out with SecureBank will show their balance, rate, and payment schedule here."
        />
    @else
        <div class="space-y-4">
            @foreach($loans as $loan)
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-base font-semibold tracking-tight text-slate-900">{{ $loan->loan_name }}</h2>
                                <x-status-badge
                                    :tone="$loan->status === 'paid_off' ? 'success' : 'brand'"
                                    :label="$loan->status === 'paid_off' ? 'Paid off' : 'Active'"
                                    dot
                                />
                            </div>
                            <p class="mt-1 text-xs text-slate-500">
                                Reference {{ $loan->reference_number }}
                                · {{ rtrim(rtrim(number_format((float) $loan->interest_rate, 2), '0'), '.') }}% APR
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-xs text-slate-500">Remaining balance</p>
                            <p class="mt-0.5 text-xl font-semibold tracking-tight tabular-nums text-slate-900" data-balance-sensitive>
                                $<x-money :amount="$loan->balance" :show-sign="false" />
                            </p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-progress
                            :value="$loan->original_amount - $loan->balance"
                            :max="$loan->original_amount"
                            :label="'Repayment progress'"
                            tone="brand"
                        />
                    </div>

                    <dl class="mt-4 grid grid-cols-2 gap-4 border-t border-slate-200 pt-4 sm:grid-cols-4">
                        <div>
                            <dt class="text-xs text-slate-500">Original amount</dt>
                            <dd class="mt-0.5 text-sm font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                                $<x-money :amount="$loan->original_amount" :show-sign="false" />
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Next payment</dt>
                            <dd class="mt-0.5 text-sm font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                                $<x-money :amount="$loan->next_payment_amount" :show-sign="false" />
                            </dd>
                            <dd class="text-xs text-slate-500">
                                {{ $loan->next_payment_date->isoFormat('MMM D') }}
                                @if($loan->daysUntilPayment() >= 0)
                                    · in {{ $loan->daysUntilPayment() }} days
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Payments remaining</dt>
                            <dd class="mt-0.5 text-sm font-semibold text-slate-900">{{ $loan->payments_remaining }}</dd>
                            <dd class="text-xs text-slate-500">of {{ $loan->term_months }} total</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Repaid</dt>
                            <dd class="mt-0.5 text-sm font-semibold text-slate-900">{{ $loan->progressPercentage() }}%</dd>
                            <dd class="text-xs text-slate-500">since {{ $loan->first_payment_date?->isoFormat('MMM Y') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('loans.show', $loan) }}"
                           class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                            View details
                        </a>
                        @if($loan->isActive())
                            <a href="{{ route('loans.payment', $loan) }}"
                               class="inline-flex items-center gap-1 rounded-lg bg-brand-700 px-3 py-1.5 text-xs font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                                Make a payment
                            </a>
                            <a href="{{ route('loans.payoff', $loan) }}"
                               class="inline-flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-100 focus-ring">
                                Get payoff quote
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
