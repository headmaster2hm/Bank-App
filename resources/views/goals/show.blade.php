@extends('layouts.banking')

@section('title', $goal->name)

@section('content')
    <x-page-header
        :title="$goal->name"
        :subtitle="$goal->purpose ?: 'Savings goal'"
        :back="route('goals.index')"
        back-label="All goals"
    />

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.2fr)]">
        <div class="space-y-5">
            <x-panel title="Progress">
                <div class="p-5">
                    <p class="text-3xl font-semibold tracking-tight tabular-nums text-slate-900" data-balance-sensitive>
                        $<x-money :amount="$goal->current_amount" :show-sign="false" />
                    </p>
                    <p class="mt-1 text-sm text-slate-500">
                        of $<span class="tabular-nums"><x-money :amount="$goal->target_amount" :show-sign="false" /></span>
                    </p>

                    <div class="mt-5">
                        <x-progress
                            :value="$goal->current_amount"
                            :max="$goal->target_amount"
                            :label="false"
                            :tone="$goal->isComplete() ? 'success' : 'brand'"
                            size="lg"
                        />
                    </div>

                    <dl class="mt-5 grid grid-cols-2 gap-4 border-t border-slate-200 pt-4 text-sm">
                        <div>
                            <dt class="text-xs text-slate-500">Progress</dt>
                            <dd class="mt-0.5 text-lg font-semibold text-slate-900">{{ $goal->percentage() }}%</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Still needed</dt>
                            <dd class="mt-0.5 text-lg font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                                $<x-money :amount="$goal->remaining()" :show-sign="false" />
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Target date</dt>
                            <dd class="mt-0.5 font-semibold text-slate-900">
                                {{ $goal->target_date?->isoFormat('F j, Y') ?? 'Open ended' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Status</dt>
                            <dd class="mt-0.5">
                                <x-status-badge
                                    :tone="$goal->status === 'complete' ? 'success' : 'brand'"
                                    :label="ucfirst($goal->status)"
                                    dot
                                />
                            </dd>
                        </div>
                    </dl>

                    @if($goal->target_date && ! $goal->isComplete())
                        @php $daysLeft = (int) now()->startOfDay()->diffInDays($goal->target_date->startOfDay(), false); @endphp
                        <p class="mt-4 rounded-lg bg-slate-50 p-3 text-xs leading-relaxed text-slate-600">
                            @if($daysLeft > 0)
                                You have {{ $daysLeft }} days left.
                                Saving $<x-money :amount="$goal->remaining()" :show-sign="false" /> over that time works out to about
                                $<x-money :amount="$goal->remaining() / max(1, intdiv($daysLeft, 7))" :show-sign="false" /> per week.
                            @else
                                This goal passed its target date. You can extend it or keep contributing.
                            @endif
                        </p>
                    @endif
                </div>
            </x-panel>

            @if($goal->status === 'active')
                <x-panel title="Add funds">
                    <form method="POST" action="{{ route('goals.contribute', $goal) }}" class="space-y-4 p-5">
                        @csrf

                        <div>
                            <label for="contribution" class="block text-sm font-medium text-slate-800">Amount</label>
                            <div class="relative mt-1.5">
                                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-500">$</span>
                                <input id="contribution" name="amount" type="number" step="0.01" min="1" required
                                       class="w-full rounded-lg border border-slate-300 py-2 pl-7 pr-3 text-sm tabular-nums focus:border-brand-500 focus-ring">
                            </div>
                        </div>

                        <div>
                            <label for="contribution_account" class="block text-sm font-medium text-slate-800">From</label>
                            <select id="contribution_account" name="account_id" required
                                    class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white py-2 text-sm focus:border-brand-500 focus-ring">
                                <option value="">Select an account</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->account_name }} — available $<span class="tabular-nums">{{ number_format((float) $account->available_balance, 2) }}</span>
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="w-full rounded-lg bg-brand-700 px-3 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                            Add to this goal
                        </button>
                    </form>
                </x-panel>
            @endif
        </div>

        <x-panel title="Contributions" description="Recent money moved into this goal">
            @if($contributions->isNotEmpty())
                <div class="divide-y divide-slate-100 p-2">
                    @foreach($contributions as $contribution)
                        <x-transaction-row :transaction="$contribution" />
                    @endforeach
                </div>
            @else
                <div class="p-5">
                    <x-empty-state
                        icon="target"
                        title="No contributions yet"
                        description="Money you add to this goal will be listed here."
                        compact
                    />
                </div>
            @endif
        </x-panel>
    </div>
@endsection
