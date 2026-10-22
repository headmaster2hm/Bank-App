@extends('layouts.banking')

@section('title', $holding->name)

@section('content')
    <x-page-header
        :title="$holding->name"
        :subtitle="$holding->symbol . ' · ' . $holding->asset_class"
        :back="route('investments.index')"
        back-label="All investments"
    />

    <div class="grid gap-5 lg:grid-cols-2">
        <x-panel title="Position">
            <div class="p-5">
                <p class="text-3xl font-semibold tracking-tight tabular-nums text-slate-900" data-balance-sensitive>
                    $<x-money :amount="$holding->marketValue()" :show-sign="false" />
                </p>
                <p class="mt-1.5 text-sm {{ $holding->isGain() ? 'text-emerald-700' : 'text-rose-700' }}">
                    {{ $holding->gainLoss() >= 0 ? '+' : '−' }}$<x-money :amount="$holding->gainLoss()" :show-sign="false" />
                    ({{ $holding->gainLossPercentage() >= 0 ? '+' : '−' }}{{ number_format(abs($holding->gainLossPercentage()), 2) }}%)
                </p>

                <dl class="mt-5 space-y-3 border-t border-slate-200 pt-4 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Quantity</dt>
                        <dd class="font-semibold tabular-nums text-slate-900">{{ rtrim(rtrim(number_format((float) $holding->quantity, 4), '0'), '.') }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Average purchase price</dt>
                        <dd class="font-semibold tabular-nums text-slate-900">$<x-money :amount="$holding->purchase_price" :show-sign="false" /></dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Current price</dt>
                        <dd class="font-semibold tabular-nums text-slate-900">$<x-money :amount="$holding->market_price" :show-sign="false" /></dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Cost basis</dt>
                        <dd class="font-semibold tabular-nums text-slate-900" data-balance-sensitive>$<x-money :amount="$holding->costBasis()" :show-sign="false" /></dd>
                    </div>
                </dl>
            </div>
        </x-panel>

        <x-panel title="About this holding">
            <div class="space-y-3 p-5 text-sm text-slate-600">
                <p>Cost basis is what you paid across every unit you hold. Gain or loss compares that with the value of your position today.</p>
                <p>This position is sample data for the SecureBank prototype. Prices are illustrative and do not update in real time.</p>
                <p>Nothing on this page is investment advice or a recommendation to buy or sell any security.</p>
            </div>
        </x-panel>
    </div>
@endsection
