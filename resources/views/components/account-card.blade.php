@props([
    'account',
    'active' => false,
])

@php
    $isCredit = in_array($account->account_type, ['credit', 'mortgage'], true);
    $status = $account->status ?? 'active';
@endphp

<a href="{{ route('accounts.show', $account) }}"
   @if($active) aria-current="page" @endif
   class="group block rounded-xl border bg-white p-4 text-left shadow-sm transition-colors hover:border-brand-300 hover:shadow focus-ring {{ $active ? 'border-brand-400 ring-1 ring-brand-200' : 'border-slate-200' }}">
    <div class="flex items-start justify-between gap-3">
        <div class="flex min-w-0 items-center gap-2.5">
            <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-700 ring-1 ring-brand-100">
                <x-icon :name="$isCredit ? 'credit-card' : 'banknotes'" class="h-4 w-4" />
            </span>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-slate-900">{{ $account->account_name }}</p>
                <p class="truncate text-xs text-slate-500">
                    {{ ucfirst($account->account_type) }} · {{ $account->maskedNumber() }}
                </p>
            </div>
        </div>

        @if($status !== 'active')
            <x-status-badge tone="warning" :label="ucfirst($status)" />
        @endif
    </div>

    <div class="mt-3.5 flex items-end justify-between gap-3">
        <div>
            <p class="text-lg font-semibold tracking-tight text-slate-900 tabular-nums">
                <x-money :amount="$account->balance" :sign="$isCredit ? 'negative' : 'auto'" :show-sign="false" />
            </p>
            @if($account->interest_rate && ! $isCredit)
                <p class="mt-0.5 text-xs text-slate-500 tabular-nums">
                    {{ rtrim(rtrim(number_format((float) $account->interest_rate, 2), '0'), '.') }}% APY
                </p>
            @elseif($isCredit && $account->credit_limit)
                <p class="mt-0.5 text-xs text-slate-500">
                    of <span class="tabular-nums">$<x-money :amount="$account->credit_limit" :show-sign="false" /></span> limit
                </p>
            @endif
        </div>

        <span class="inline-flex items-center gap-0.5 text-xs font-semibold text-brand-700 opacity-0 transition-opacity group-hover:opacity-100 group-focus-visible:opacity-100">
            View
            <x-icon name="chevron-right" class="h-3.5 w-3.5" />
        </span>
    </div>
</a>
