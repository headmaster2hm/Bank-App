@props([
    'transaction',
    'showAccount' => false,
    'href' => null,
    'compact' => false,
])

@php
    $type = $transaction->type;
    $isCredit = in_array($type, ['deposit', 'transfer_in', 'payment'], true);
    $isTransfer = in_array($type, ['transfer_in', 'transfer_out'], true);

    $icon = match ($type) {
        'deposit', 'transfer_in' => 'arrow-down-left',
        'transfer_out' => 'arrows',
        'withdrawal' => 'credit-card',
        default => 'banknotes',
    };

    $pending = ($transaction->status ?? 'completed') !== 'completed';
    $target = $href ?? route('transactions.show', $transaction);
    $category = $transaction->category;

    $tone = $isCredit
        ? 'bg-emerald-50 text-emerald-700 ring-emerald-100'
        : ($isTransfer ? 'bg-slate-50 text-slate-600 ring-slate-200' : 'bg-brand-50 text-brand-700 ring-brand-100');
@endphp

<a href="{{ $target }}"
   class="group flex items-center gap-3 rounded-lg px-2 py-2.5 transition-colors hover:bg-slate-50 focus-ring sm:px-3 {{ $compact ? '' : '' }}">
    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg ring-1 {{ $tone }}">
        <x-icon :name="$icon" class="h-4 w-4" />
    </span>

    <div class="min-w-0 flex-1">
        <p class="truncate text-sm font-medium text-slate-900">
            {{ $transaction->description }}
        </p>
        <p class="mt-0.5 flex flex-wrap items-center gap-x-1.5 text-xs text-slate-500">
            <time datetime="{{ $transaction->created_at->toIso8601String() }}">
                {{ $transaction->created_at->isoFormat('MMM D') }}
            </time>
            <span aria-hidden="true">·</span>
            <span>{{ $transaction->created_at->isoFormat('h:mm A') }}</span>
            @if($showAccount && $transaction->account)
                <span aria-hidden="true">·</span>
                <span class="truncate">{{ $transaction->account->maskedNumber() }}</span>
            @endif
            @if($pending)
                <span aria-hidden="true">·</span>
                <x-status-badge tone="warning" label="Pending" />
            @endif
        </p>
    </div>

    <div class="shrink-0 text-right">
        <p class="text-sm font-semibold tabular-nums {{ $isCredit ? 'text-emerald-700' : 'text-slate-900' }}">
            <x-money :amount="$transaction->amount" :sign="$isCredit ? 'positive' : 'negative'" />
        </p>
        @if($category)
            <p class="mt-0.5 text-xs text-slate-500">{{ \App\Services\DashboardSummary::categoryLabel($category) }}</p>
        @endif
    </div>
</a>
