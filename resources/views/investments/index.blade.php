@extends('layouts.banking')

@section('title', 'Investments')

@section('content')
    <x-page-header
        title="Investments"
        subtitle="Holdings, cost basis, and how your portfolio is tracking."
    />

    <div class="mb-5 grid gap-4 sm:grid-cols-3">
        <x-stat label="Portfolio value" :value="'$' . number_format($totalValue, 2)" icon="chart" :blank="true" />
        <x-stat
            label="Total gain"
            :value="($totalGain >= 0 ? '+' : '−') . '$' . number_format(abs($totalGain), 2)"
            icon="trend-up"
            :tone="$totalGain >= 0 ? 'success' : 'muted'"
            :hint="$totalGainPercent >= 0 ? '+' : '−' . number_format(abs($totalGainPercent), 2) . '% all time'"
        />
        <x-stat label="Cost basis" :value="'$' . number_format($totalCost, 2)" icon="receipt" :blank="true" />
    </div>

    <div class="mb-5">
        <x-alert tone="info" icon="info" title="Demonstration portfolio">
            These holdings are sample data for the SecureBank prototype. Prices are illustrative, are not updated in real time, and are not a recommendation to buy or sell anything.
        </x-alert>
    </div>

    @if($holdings->isEmpty())
        <x-empty-state
            icon="chart"
            title="No holdings yet"
            description="Investments you hold with SecureBank will appear here with cost basis and performance."
        />
    @else
        <div class="grid gap-5 lg:grid-cols-[minmax(0,1.5fr)_minmax(0,1fr)]">
            <x-panel :title="Str::plural('Holding', $holdings->count())" description="Market value against what you paid">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[36rem] text-sm">
                        <caption class="sr-only">Investment holdings with market value and gain or loss</caption>
                        <thead>
                            <tr class="border-b border-slate-200 text-left">
                                <th scope="col" class="px-5 py-2.5 text-xs font-semibold uppercase tracking-wide text-slate-500">Holding</th>
                                <th scope="col" class="px-3 py-2.5 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Quantity</th>
                                <th scope="col" class="px-3 py-2.5 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Value</th>
                                <th scope="col" class="px-5 py-2.5 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Gain / loss</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($holdings as $holding)
                                <tr class="transition-colors hover:bg-slate-50">
                                    <th scope="row" class="px-5 py-3 text-left font-normal">
                                        <a href="{{ route('investments.show', $holding) }}" class="group inline-flex items-center gap-2.5 focus-ring">
                                            <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-bank-900 text-xs font-bold text-white">
                                                {{ Str::limit($holding->symbol, 4) }}
                                            </span>
                                            <span class="min-w-0">
                                                <span class="block text-sm font-semibold text-slate-900 group-hover:text-brand-800">{{ $holding->name }}</span>
                                                <span class="block text-xs text-slate-500">{{ $holding->asset_class }}</span>
                                            </span>
                                        </a>
                                    </th>
                                    <td class="px-3 py-3 text-right tabular-nums text-slate-700">
                                        {{ rtrim(rtrim(number_format((float) $holding->quantity, 4), '0'), '.') }}
                                    </td>
                                    <td class="px-3 py-3 text-right font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                                        $<x-money :amount="$holding->marketValue()" :show-sign="false" />
                                    </td>
                                    <td class="px-5 py-3 text-right tabular-nums">
                                        <span class="font-semibold {{ $holding->isGain() ? 'text-emerald-700' : 'text-rose-700' }}">
                                            {{ $holding->gainLoss() >= 0 ? '+' : '−' }}$<x-money :amount="$holding->gainLoss()" :show-sign="false" />
                                        </span>
                                        <span class="mt-0.5 block text-xs {{ $holding->isGain() ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ $holding->gainLossPercentage() >= 0 ? '+' : '−' }}{{ number_format(abs($holding->gainLossPercentage()), 2) }}%
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-panel>

            <x-panel title="By asset class" description="Where your portfolio is invested">
                <div class="space-y-4 p-5">
                    @foreach($byClass as $class => $value)
                        @php $share = $totalValue > 0 ? ($value / $totalValue) * 100 : 0; @endphp
                        <div>
                            <div class="mb-1.5 flex items-baseline justify-between gap-3">
                                <span class="text-sm font-medium text-slate-700">{{ $class }}</span>
                                <span class="text-xs tabular-nums text-slate-500">
                                    $<x-money :amount="$value" :show-sign="false" /> · {{ number_format($share, 1) }}%
                                </span>
                            </div>
                            <x-progress :value="$value" :max="$totalValue" :label="false" size="sm" />
                        </div>
                    @endforeach
                </div>
            </x-panel>
        </div>
    @endif
@endsection
