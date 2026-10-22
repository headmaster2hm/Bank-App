@extends('layouts.banking')

@section('title', $biller->name)

@section('content')
    <x-page-header
        :title="$biller->name"
        :subtitle="$biller->category ? $biller->category . ' biller' : 'Saved biller'"
        :back="route('billers.index')"
        back-label="All billers"
    >
        <x-slot:actions>
            @if($biller->status === 'due')
                <a href="{{ route('billers.pay', $biller) }}"
                   class="inline-flex items-center gap-1.5 rounded-lg bg-brand-700 px-3 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                    Pay this bill
                </a>
            @endif
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.2fr)]">
        <div class="space-y-5">
            <x-panel title="Amount due">
                <div class="p-5">
                    <p class="text-3xl font-semibold tracking-tight tabular-nums text-slate-900" data-balance-sensitive>
                        $<x-money :amount="$biller->amount_due" :show-sign="false" />
                    </p>
                    <p class="mt-1.5 text-sm {{ $biller->isOverdue() && $biller->status === 'due' ? 'font-medium text-rose-700' : 'text-slate-600' }}">
                        {{ $biller->status === 'paid' ? 'Paid. Next bill expected ' . $biller->due_date->isoFormat('F j, Y') : $biller->dueLabel() }}
                    </p>

                    <dl class="mt-5 space-y-3 border-t border-slate-200 pt-4 text-sm">
                        <div class="flex items-center justify-between gap-3">
                            <dt class="text-slate-500">Due date</dt>
                            <dd class="font-semibold text-slate-900">{{ $biller->due_date->isoFormat('l, F j, Y') }}</dd>
                        </div>
                        @if($biller->account_reference)
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-slate-500">Your reference</dt>
                                <dd class="font-semibold text-slate-900">{{ $biller->account_reference }}</dd>
                            </div>
                        @endif
                        @if($biller->account)
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-slate-500">Paying from</dt>
                                <dd class="text-right font-semibold text-slate-900">
                                    <a href="{{ route('accounts.show', $biller->account) }}" class="hover:text-brand-800 focus-ring">
                                        {{ $biller->account->account_name }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                        <div class="flex items-center justify-between gap-3">
                            <dt class="text-slate-500">Autopay</dt>
                            <dd>
                                <x-status-badge
                                    :tone="$biller->autopay ? 'success' : 'neutral'"
                                    :label="$biller->autopay ? 'On, ' . ucfirst($biller->autopay_frequency ?? 'monthly') : 'Off'"
                                    dot
                                />
                            </dd>
                        </div>
                    </dl>

                    <form method="POST" action="{{ route('billers.autopay', $biller) }}" class="mt-4 border-t border-slate-200 pt-4">
                        @csrf
                        <button type="submit"
                                class="w-full rounded-lg px-3 py-2 text-sm font-semibold transition-colors focus-ring
                                       {{ $biller->autopay
                                          ? 'border border-emerald-300 bg-emerald-50 text-emerald-900 hover:bg-emerald-100'
                                          : 'border border-slate-300 text-slate-700 hover:bg-slate-50' }}">
                            {{ $biller->autopay ? 'Turn autopay off' : 'Turn autopay on' }}
                        </button>
                    </form>
                </div>
            </x-panel>

            <x-panel title="Remove biller">
                <div class="p-5">
                    <p class="text-sm text-slate-600">Removing this biller does not cancel payments you have already sent, and it does not close your account with the company.</p>
                    <form method="POST" action="{{ route('billers.destroy', $biller) }}" class="mt-3"
                          onsubmit="return confirm('Remove this biller?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-lg border border-rose-300 px-3 py-2 text-sm font-semibold text-rose-700 transition-colors hover:bg-rose-50 focus-ring">
                            Remove biller
                        </button>
                    </form>
                </div>
            </x-panel>
        </div>

        <x-panel title="Payment history" description="Payments sent to this biller">
            @if($history->isNotEmpty())
                <div class="divide-y divide-slate-100 p-2">
                    @foreach($history as $payment)
                        <x-transaction-row :transaction="$payment" />
                    @endforeach
                </div>
            @else
                <div class="p-5">
                    <x-empty-state icon="receipt" title="No payments yet" description="Payments you send to this biller will be listed here." compact />
                </div>
            @endif
        </x-panel>
    </div>
@endsection
