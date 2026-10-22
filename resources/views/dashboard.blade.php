@php
    $user = auth()->user();
    $hour = (int) now()->format('G');
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
    $firstName = $user->firstName();
    $isProtected = $preference?->two_factor_enabled ?? false;
@endphp

@extends('layouts.banking')

@section('title', 'Overview')

@section('content')
    <x-page-header
        :title="$greeting . ', ' . $firstName"
        :subtitle="'Last sign-in activity: ' . ($user->securityEvents()->where('event_type', 'login')->latest('occurred_at')->value('occurred_at')?->isoFormat('MMM D [at] h:mm A') ?? 'this session')">
        <x-slot:actions>
            @if(! $isProtected)
                <a href="{{ route('security.index') }}"
                   class="inline-flex items-center gap-1.5 rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-sm font-semibold text-amber-900 transition-colors hover:bg-amber-100 focus-ring">
                    <x-icon name="shield" class="h-4 w-4" />
                    Turn on two-step verification
                </a>
            @endif

            <button type="button" data-toggle-balances aria-pressed="true"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                <x-icon name="eye-off" class="h-4 w-4" data-balance-icon />
                <span data-balance-toggle-label>Hide balances</span>
            </button>
        </x-slot:actions>
    </x-page-header>

    {{-- Primary balance summary --}}
    <section class="mb-5" aria-labelledby="net-worth-heading">
        <div class="grid gap-4 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,1fr)]">
            <div class="relative overflow-hidden rounded-xl bg-bank-900 p-5 text-white shadow-sm sm:p-6">
                <span class="pointer-events-none absolute -right-16 -top-20 h-56 w-56 rounded-full bg-brand-700/40" aria-hidden="true"></span>
                <span class="pointer-events-none absolute -bottom-24 -left-10 h-52 w-52 rounded-full bg-accent-600/20" aria-hidden="true"></span>

                <div class="relative">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h2 id="net-worth-heading" class="text-xs font-semibold uppercase tracking-[0.14em] text-brand-200">
                                Total net worth
                            </h2>
                            <p class="mt-2 text-3xl font-semibold tracking-tight tabular-nums sm:text-4xl" data-balance-sensitive>
                                <x-money :amount="$netWorth" :show-sign="false" />
                            </p>
                            <p class="mt-1.5 text-sm text-brand-200">
                                Across {{ $accounts->count() }} {{ Str::plural('account', $accounts->count()) }}
                                · updated {{ now()->isoFormat('MMM D, h:mm A') }}
                            </p>
                        </div>

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-2.5 py-1 text-xs font-medium text-white ring-1 ring-inset ring-white/15">
                            @if($isProtected)
                                <x-icon name="shield" class="h-3.5 w-3.5 text-emerald-300" />
                                Two-step verification on
                            @else
                                <x-icon name="alert" class="h-3.5 w-3.5 text-amber-300" />
                                Verification not enabled
                            @endif
                        </span>
                    </div>

                    <dl class="mt-6 grid grid-cols-2 gap-x-6 gap-y-4 border-t border-white/10 pt-5 sm:grid-cols-3">
                        <div>
                            <dt class="text-xs font-medium text-brand-200">Available to spend</dt>
                            <dd class="mt-1 text-lg font-semibold tabular-nums" data-balance-sensitive>
                                <x-money :amount="$availableCash" :show-sign="false" />
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-brand-200">Credit limit</dt>
                            <dd class="mt-1 text-lg font-semibold tabular-nums" data-balance-sensitive>
                                <x-money :amount="$totalCreditLimit" :show-sign="false" />
                            </dd>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <dt class="text-xs font-medium text-brand-200">Total borrowed</dt>
                            <dd class="mt-1 text-lg font-semibold tabular-nums" data-balance-sensitive>
                                <x-money :amount="$totalDebt" :show-sign="false" />
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold tracking-tight text-slate-900">Quick actions</h2>
                <p class="mt-0.5 text-xs text-slate-500">Common tasks, one tap away.</p>

                <div class="mt-4 grid grid-cols-2 gap-2.5">
                    <x-quick-action label="Transfer" description="Between accounts" icon="arrows" :href="route('transfer')" />
                    <x-quick-action label="Pay a bill" description="Manage billers" icon="receipt" :href="route('billers.index')" />
                    <x-quick-action label="Deposit" description="Mobile deposit" icon="arrow-down-left" :href="route('deposit.mobile')" />
                    <x-quick-action label="Withdraw" description="Cash out" icon="credit-card" :href="route('withdraw')" />
                </div>
            </div>
        </div>
    </section>

    {{-- Accounts --}}
    <section class="mb-5" aria-labelledby="accounts-heading">
        <x-panel title="Your accounts" description="Balances and available funds" :href="route('accounts.index')" link-label="View all">
            <x-slot:header>
                <a href="{{ route('accounts.create') }}"
                   class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                    <x-icon name="plus" class="h-3.5 w-3.5" />
                    Open account
                </a>
            </x-slot:header>

            <div class="space-y-4 p-5">
                @forelse($grouped as $group)
                    @if($group['accounts']->isNotEmpty())
                        <div>
                            <h3 class="mb-2 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-500">
                                {{ $group['label'] }}
                            </h3>
                            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                                @foreach($group['accounts'] as $account)
                                    <x-account-card :account="$account" />
                                @endforeach
                            </div>
                        </div>
                    @endif
                @empty
                    <x-empty-state
                        icon="building"
                        title="No accounts yet"
                        description="Open a checking or savings account to start using online banking."
                        action-label="Open an account"
                        :action-href="route('accounts.create')"
                    />
                @endforelse
            </div>
        </x-panel>
    </section>

    {{-- Activity, spending, and cash flow --}}
    <div class="mb-5 grid gap-5 xl:grid-cols-3">
        <x-panel class="xl:col-span-2" title="Recent activity" description="Your latest transactions" :href="route('transactions.index')" link-label="View all">
            @if($recentTransactions->isNotEmpty())
                <div class="divide-y divide-slate-100 p-2">
                    @foreach($recentTransactions as $transaction)
                        <x-transaction-row :transaction="$transaction" show-account />
                    @endforeach
                </div>
            @else
                <div class="p-5">
                    <x-empty-state
                        icon="activity"
                        title="No activity yet"
                        description="Transactions will appear here once money moves through your accounts."
                        compact
                    />
                </div>
            @endif
        </x-panel>

        <x-panel title="Spending this month" description="Where your money went">
            @if($spending)
                <div class="space-y-5 p-5">
                    <div class="flex justify-center">
                        <x-donut-chart :slices="$spending" :total="$spendingTotal" center-label="Total" />
                    </div>

                    <ul class="space-y-2">
                        @foreach($spending as $row)
                            <li class="flex items-center justify-between gap-3 text-sm">
                                <span class="flex min-w-0 items-center gap-2">
                                    <span class="h-2.5 w-2.5 shrink-0 rounded-sm" style="background-color: {{ $row['color'] }}" aria-hidden="true"></span>
                                    <span class="truncate text-slate-700">{{ $row['label'] }}</span>
                                </span>
                                <span class="flex shrink-0 items-baseline gap-2">
                                    <span class="font-semibold tabular-nums text-slate-900" data-balance-sensitive>$<x-money :amount="$row['total']" :show-sign="false" /></span>
                                    <span class="w-10 text-right text-xs tabular-nums text-slate-500">{{ $row['percentage'] }}%</span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="p-5">
                    <x-empty-state icon="chart" title="No spending recorded" description="Spending categories appear here once you spend money." compact />
                </div>
            @endif
        </x-panel>
    </div>

    {{-- Cash flow and monthly trend --}}
    <div class="mb-5 grid gap-5 lg:grid-cols-2">
        <x-panel title="Cash flow" description="Money in compared with money out">
            <div class="p-5">
                <x-bar-chart :series="$cashFlow" />

                <dl class="mt-5 grid grid-cols-3 gap-3 border-t border-slate-200 pt-4">
                    <div>
                        <dt class="text-xs text-slate-500">In this month</dt>
                        <dd class="mt-0.5 text-sm font-semibold tabular-nums text-emerald-700" data-balance-sensitive>
                            <x-money :amount="$monthIncome" :show-sign="false" />
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-500">Out this month</dt>
                        <dd class="mt-0.5 text-sm font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                            <x-money :amount="$monthOutflow" :show-sign="false" />
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-500">Net</dt>
                        <dd class="mt-0.5 text-sm font-semibold tabular-nums {{ $monthNet >= 0 ? 'text-emerald-700' : 'text-rose-700' }}" data-balance-sensitive>
                            <x-money :amount="$monthNet" />
                        </dd>
                    </div>
                </dl>
            </div>
        </x-panel>

        <x-panel title="Month to date" description="Compared with the same days last month">
            @if($trends)
                <div class="divide-y divide-slate-100">
                    @foreach($trends->take(6) as $row)
                        @php
                            $deltaLabel = match ($row['direction']) {
                                'flat' => 'No change',
                                default => abs($row['delta']) < 100
                                    ? '$'.number_format(abs($row['delta']), 0)
                                    : number_format(abs($row['delta']) / 1000, 1).'k',
                            };
                        @endphp
                        <div class="flex items-center gap-4 px-5 py-3">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-900">{{ $row['label'] }}</p>
                                <p class="mt-0.5 text-xs tabular-nums text-slate-500">
                                    Same period last month $<x-money :amount="$row['previous']" :show-sign="false" />
                                </p>
                            </div>

                            <div class="w-28 shrink-0">
                                <x-progress
                                    :value="$row['current']"
                                    :max="max($trends->max('current'), 1)"
                                    :tone="$row['direction'] === 'down' ? 'success' : 'brand'"
                                    size="sm"
                                />
                            </div>

                            <div class="w-24 shrink-0 text-right">
                                <p class="text-sm font-semibold tabular-nums text-slate-900" data-balance-sensitive>$<x-money :amount="$row['current']" :show-sign="false" /></p>
                                <p class="mt-0.5 inline-flex items-center gap-0.5 text-xs tabular-nums
                                          {{ $row['direction'] === 'up' ? 'text-amber-700' : ($row['direction'] === 'down' ? 'text-emerald-700' : 'text-slate-500') }}">
                                    @if($row['direction'] === 'up')
                                        <x-icon name="trend-up" class="h-3 w-3" />
                                    @elseif($row['direction'] === 'down')
                                        <x-icon name="trend-down" class="h-3 w-3" />
                                    @endif
                                    {{ $deltaLabel }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-5">
                    <x-empty-state icon="trend-up" title="Not enough history" description="Compare categories after a full month of activity." compact />
                </div>
            @endif
        </x-panel>
    </div>

    {{-- Goals, upcoming, credit --}}
    <div class="mb-5 grid gap-5 lg:grid-cols-2">
        <x-panel title="Savings goals" description="Progress toward your targets" :href="route('goals.index')" link-label="Manage goals">
            <x-slot:header>
                <a href="{{ route('goals.create') }}"
                   class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                    <x-icon name="plus" class="h-3.5 w-3.5" /> New goal
                </a>
            </x-slot:header>

            @if($goals->isNotEmpty())
                <div class="space-y-4 p-5">
                    @foreach($goals as $goal)
                        <div>
                            <div class="mb-1.5 flex items-baseline justify-between gap-3">
                                <a href="{{ route('goals.show', $goal) }}" class="truncate text-sm font-semibold text-slate-900 hover:text-brand-800 focus-ring">{{ $goal->name }}</a>
                                <span class="shrink-0 text-xs tabular-nums text-slate-500">
                                    <span class="font-semibold text-slate-700" data-balance-sensitive>$<x-money :amount="$goal->current_amount" :show-sign="false" /></span>
                                    of $<x-money :amount="$goal->target_amount" :show-sign="false" />
                                </span>
                            </div>
                            <x-progress :value="$goal->current_amount" :max="$goal->target_amount" :label="false" tone="accent" size="sm" />
                            <p class="mt-1 text-xs text-slate-500">
                                {{ $goal->percentage() }}% funded
                                @if($goal->target_date)
                                    · target {{ $goal->target_date->isoFormat('MMM Y') }}
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-5">
                    <x-empty-state
                        icon="target"
                        title="No goals yet"
                        description="Set a savings goal and track how close you are to reaching it."
                        action-label="Create a goal"
                        :action-href="route('goals.create')"
                        compact
                    />
                </div>
            @endif
        </x-panel>

        <x-panel title="Coming up" description="Bills and transfers due soon">
            @if($upcomingBills->isNotEmpty() || $upcomingTransfers->isNotEmpty())
                <div class="divide-y divide-slate-100">
                    @foreach($upcomingBills as $biller)
                        <div class="flex items-center gap-3 px-5 py-3">
                            <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-700 ring-1 ring-brand-100">
                                <x-icon name="receipt" class="h-4 w-4" />
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-900">{{ $biller->name }}</p>
                                <p class="mt-0.5 text-xs {{ $biller->isOverdue() ? 'font-medium text-rose-700' : 'text-slate-500' }}">
                                    {{ $biller->dueLabel() }}
                                    @if($biller->autopay)
                                        · autopay on
                                    @endif
                                </p>
                            </div>
                            <div class="shrink-0 text-right">
                                <p class="text-sm font-semibold tabular-nums text-slate-900" data-balance-sensitive>$<x-money :amount="$biller->amount_due" :show-sign="false" /></p>
                                <a href="{{ route('billers.pay', $biller) }}" class="mt-0.5 inline-block text-xs font-semibold text-brand-700 hover:text-brand-900 focus-ring">Pay now</a>
                            </div>
                        </div>
                    @endforeach

                    @foreach($upcomingTransfers as $transfer)
                        <div class="flex items-center gap-3 px-5 py-3">
                            <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-50 text-slate-600 ring-1 ring-slate-200">
                                <x-icon name="arrows" class="h-4 w-4" />
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-900">{{ $transfer->description }}</p>
                                <p class="mt-0.5 truncate text-xs text-slate-500">
                                    {{ $transfer->frequencyLabel() }} · {{ $transfer->next_run_date->diffForHumans() }}
                                </p>
                            </div>
                            <p class="shrink-0 text-sm font-semibold tabular-nums text-slate-900" data-balance-sensitive>$<x-money :amount="$transfer->amount" :show-sign="false" /></p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-5">
                    <x-empty-state icon="calendar" title="Nothing scheduled" description="Upcoming bills and scheduled transfers will appear here." compact />
                </div>
            @endif
        </x-panel>
    </div>

    {{-- Credit, cards, and loans --}}
    <div class="mb-5 grid gap-5 lg:grid-cols-3">
        @if($creditProfile)
            <x-panel title="Credit score" description="Updated {{ $creditProfile->updated_at_date->diffForHumans() }}">
                <div class="p-5">
                    <div class="flex items-end justify-between gap-3">
                        <p class="text-3xl font-semibold tracking-tight tabular-nums text-slate-900">{{ $creditProfile->score }}</p>
                        <x-status-badge :tone="$creditProfile->tone()" :label="$creditProfile->range_label" dot />
                    </div>
                    <p class="mt-1.5 inline-flex items-center gap-1 text-sm {{ $creditProfile->change() >= 0 ? 'text-emerald-700' : 'text-amber-700' }}">
                        <x-icon :name="$creditProfile->change() >= 0 ? 'trend-up' : 'trend-down'" class="h-4 w-4" />
                        {{ $creditProfile->changeLabel() }}
                    </p>

                    <div class="mt-5">
                        <div class="relative h-2 rounded-full bg-gradient-to-r from-rose-400 via-amber-400 to-emerald-500" role="img"
                             aria-label="Score {{ $creditProfile->score }} of 850, rated {{ $creditProfile->range_label }}">
                            <span class="absolute top-1/2 h-4 w-4 -translate-x-1/2 -translate-y-1/2 rounded-full border-2 border-white bg-slate-900 shadow"
                                  style="left: {{ round(($creditProfile->score / 850) * 100, 1) }}%" aria-hidden="true"></span>
                        </div>
                        <div class="mt-1.5 flex justify-between text-[10px] font-medium text-slate-500">
                            <span>300</span><span>580</span><span>670</span><span>740</span><span>850</span>
                        </div>
                    </div>

                    <p class="mt-4 rounded-lg bg-slate-50 p-3 text-xs leading-relaxed text-slate-600">
                        This is a sample score for demonstration. It is not calculated from your SecureBank activity and does not affect any product.
                    </p>
                </div>
            </x-panel>
        @endif

        <x-panel title="Your cards" :href="route('cards.index')" link-label="Manage">
            @if($creditCards->isNotEmpty())
                <div class="space-y-3 p-5">
                    @foreach($creditCards as $card)
                        <div>
                            <div class="mb-1.5 flex items-baseline justify-between gap-3">
                                <p class="truncate text-sm font-semibold text-slate-900">{{ $card->card_name }}</p>
                                <p class="shrink-0 text-xs tabular-nums text-slate-500">{{ $card->utilisationPercentage() }}% used</p>
                            </div>
                            <x-progress :value="$card->current_balance" :max="$card->credit_limit" :label="false" size="sm" tone="brand" />
                            <p class="mt-1 text-xs text-slate-500">
                                <span data-balance-sensitive>$<x-money :amount="$card->availableCredit()" :show-sign="false" /></span>
                                available of $<x-money :amount="$card->credit_limit" :show-sign="false" />
                                @if($card->frozen)
                                    · <span class="font-semibold text-amber-700">Frozen</span>
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-5">
                    <x-empty-state icon="card" title="No credit cards" description="Cards you add will show balances and limits here." compact />
                </div>
            @endif
        </x-panel>

        <x-panel title="Loans" :href="route('loans.index')" link-label="View all">
            @if($loans->isNotEmpty())
                <div class="divide-y divide-slate-100">
                    @foreach($loans as $loan)
                        <div class="px-5 py-3.5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-slate-900">{{ $loan->loan_name }}</p>
                                    <p class="mt-0.5 text-xs text-slate-500">Next payment {{ $loan->next_payment_date->isoFormat('MMM D') }}</p>
                                </div>
                                <p class="shrink-0 text-sm font-semibold tabular-nums text-slate-900" data-balance-sensitive>$<x-money :amount="$loan->balance" :show-sign="false" /></p>
                            </div>
                            <div class="mt-2.5">
                                <x-progress :value="$loan->original_amount - $loan->balance" :max="$loan->original_amount" :label="false" size="sm" />
                            </div>
                            <p class="mt-1 text-xs text-slate-500">{{ $loan->progressPercentage() }}% repaid · {{ $loan->payments_remaining }} payments left</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-5">
                    <x-empty-state icon="mortgage" title="No active loans" description="Loans you take out will appear here." compact />
                </div>
            @endif
        </x-panel>
    </div>

    {{-- Documents --}}
    <x-panel title="Recent statements" description="Download your latest documents" :href="route('documents.index')" link-label="All documents">
        @if($documents->isNotEmpty())
            <div class="divide-y divide-slate-100">
                @foreach($documents as $document)
                    <div class="flex items-center gap-3 px-5 py-3">
                        <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-50 text-slate-500 ring-1 ring-slate-200">
                            <x-icon name="document" class="h-4 w-4" />
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-slate-900">{{ $document->title }}</p>
                            <p class="mt-0.5 truncate text-xs text-slate-500">
                                {{ $document->period_label }} · issued {{ $document->document_date->isoFormat('MMM D, Y') }}
                            </p>
                        </div>
                        <a href="{{ route('documents.download', $document) }}"
                           class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-700 focus-ring">
                            <x-icon name="download" class="h-4 w-4" />
                            <span class="sr-only">Download {{ $document->title }} {{ $document->period_label }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-5">
                <x-empty-state icon="document" title="No statements yet" description="Your monthly statements will be available to download here." compact />
            </div>
        @endif
    </x-panel>
@endsection
