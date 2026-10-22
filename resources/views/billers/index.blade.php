@extends('layouts.banking')

@section('title', 'Pay a bill')

@section('content')
    <x-page-header
        title="Pay a bill"
        subtitle="Your saved billers, what is due, and when autopay runs."
    >
        <x-slot:actions>
            <a href="{{ route('billers.create') }}"
               class="inline-flex items-center gap-1.5 rounded-lg bg-brand-700 px-3 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                <x-icon name="plus" class="h-4 w-4" />
                Add biller
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="mb-5 grid gap-4 sm:grid-cols-3">
        <x-stat label="Due now" :value="'$' . number_format($totalDue, 2)" icon="receipt" :blank="true" />
        <x-stat label="Billers" :value="$billers->count()" icon="document" />
        <x-stat label="On autopay" :value="$autopayCount" icon="check-circle" tone="success" />
    </div>

    @if($billers->isEmpty())
        <x-empty-state
            icon="receipt"
            title="No billers saved"
            description="Add a biller once and pay it any time, or turn on autopay to pay it automatically."
            action-label="Add your first biller"
            :action-href="route('billers.create')"
        />
    @else
        <x-panel title="Your billers">
            <div class="divide-y divide-slate-100">
                @foreach($billers as $biller)
                    <div class="flex flex-wrap items-center gap-4 px-5 py-4">
                        <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-700 ring-1 ring-brand-100">
                            <x-icon name="receipt" class="h-5 w-5" />
                        </span>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('billers.show', $biller) }}" class="truncate text-sm font-semibold text-slate-900 hover:text-brand-800 focus-ring">
                                    {{ $biller->name }}
                                </a>
                                @if($biller->autopay)
                                    <x-status-badge tone="success" label="Autopay" dot />
                                @endif
                                @if($biller->isOverdue() && $biller->status === 'due')
                                    <x-status-badge tone="danger" label="Overdue" />
                                @endif
                            </div>
                            <p class="mt-0.5 text-xs text-slate-500">
                                @if($biller->account_reference)
                                    Ref {{ $biller->account_reference }} ·
                                @endif
                                @if($biller->category)
                                    {{ $biller->category }} ·
                                @endif
                                <span class="{{ $biller->isOverdue() && $biller->status === 'due' ? 'font-medium text-rose-700' : '' }}">
                                    {{ $biller->status === 'paid' ? 'Paid' : $biller->dueLabel() }}
                                </span>
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-base font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                                $<x-money :amount="$biller->amount_due" :show-sign="false" />
                            </p>
                        </div>

                        <div class="flex shrink-0 flex-wrap gap-2">
                            @if($biller->status === 'due')
                                <a href="{{ route('billers.pay', $biller) }}"
                                   class="rounded-lg bg-brand-700 px-3 py-1.5 text-xs font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                                    Pay now
                                </a>
                            @else
                                <form method="POST" action="{{ route('billers.unpay', $biller) }}">
                                    @csrf
                                    <button type="submit" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                                        Mark unpaid
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('billers.autopay', $biller) }}">
                                @csrf
                                <button type="submit"
                                        class="rounded-lg border px-3 py-1.5 text-xs font-semibold transition-colors focus-ring
                                               {{ $biller->autopay
                                                  ? 'border-emerald-300 bg-emerald-50 text-emerald-900 hover:bg-emerald-100'
                                                  : 'border-slate-300 text-slate-700 hover:bg-slate-50' }}">
                                    {{ $biller->autopay ? 'Autopay on' : 'Turn on autopay' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-panel>
    @endif
@endsection
