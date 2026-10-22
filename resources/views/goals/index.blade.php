@extends('layouts.banking')

@section('title', 'Savings goals')

@section('content')
    <x-page-header
        title="Savings goals"
        subtitle="Set targets for what you are working toward and track progress."
    >
        <x-slot:actions>
            <a href="{{ route('goals.create') }}"
               class="inline-flex items-center gap-1.5 rounded-lg bg-brand-700 px-3 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                <x-icon name="plus" class="h-4 w-4" />
                New goal
            </a>
        </x-slot:actions>
    </x-page-header>

    @if($goals->isEmpty())
        <x-empty-state
            icon="target"
            title="No goals yet"
            description="Create a goal with an amount and a date, then contribute to it whenever you can."
            action-label="Create your first goal"
            :action-href="route('goals.create')"
        />
    @else
        <div class="mb-5 grid gap-4 sm:grid-cols-3">
            <x-stat label="Saved so far" :value="'$' . number_format($totalSaved, 2)" icon="target" :blank="true" />
            <x-stat label="Combined target" :value="'$' . number_format($totalTarget, 2)" icon="chart" :blank="true" />
            <x-stat
                label="Overall progress"
                :value="($totalTarget > 0 ? round(($totalSaved / $totalTarget) * 100, 1) : 0) . '%'"
                icon="check-circle"
                tone="success"
            />
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            @foreach($goals as $goal)
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="truncate text-base font-semibold tracking-tight text-slate-900">{{ $goal->name }}</h2>
                            @if($goal->purpose)
                                <p class="mt-0.5 text-sm text-slate-500">{{ $goal->purpose }}</p>
                            @endif
                        </div>
                        <x-status-badge
                            :tone="$goal->status === 'complete' ? 'success' : ($goal->status === 'cancelled' ? 'neutral' : 'brand')"
                            :label="$goal->status === 'complete' ? 'Reached' : ucfirst($goal->status)"
                            dot
                        />
                    </div>

                    <div class="mt-4">
                        <x-progress
                            :value="$goal->current_amount"
                            :max="$goal->target_amount"
                            :label="false"
                            :tone="$goal->isComplete() ? 'success' : 'brand'"
                            size="lg"
                        />
                    </div>

                    <div class="mt-2.5 flex items-baseline justify-between gap-3">
                        <p class="text-sm font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                            $<x-money :amount="$goal->current_amount" :show-sign="false" />
                        </p>
                        <p class="text-xs tabular-nums text-slate-500">
                            of $<x-money :amount="$goal->target_amount" :show-sign="false" />
                        </p>
                    </div>

                    <dl class="mt-4 grid grid-cols-3 gap-3 border-t border-slate-200 pt-4 text-sm">
                        <div>
                            <dt class="text-xs text-slate-500">Progress</dt>
                            <dd class="mt-0.5 font-semibold text-slate-900">{{ $goal->percentage() }}%</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Still needed</dt>
                            <dd class="mt-0.5 font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                                $<x-money :amount="$goal->remaining()" :show-sign="false" />
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Target date</dt>
                            <dd class="mt-0.5 font-semibold text-slate-900">
                                {{ $goal->target_date?->isoFormat('MMM Y') ?? 'Open ended' }}
                            </dd>
                        </div>
                    </dl>

                    @if($goal->status === 'active')
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('goals.show', $goal) }}"
                               class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                                Add funds
                            </a>
                            <form method="POST" action="{{ route('goals.cancel', $goal) }}"
                                  onsubmit="return confirm('Cancel this goal? Funds already saved stay in your account.');">
                                @csrf
                                <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-600 transition-colors hover:bg-slate-100 hover:text-rose-700 focus-ring">
                                    Cancel goal
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection
