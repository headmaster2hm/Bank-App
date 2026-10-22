@extends('layouts.banking')

@section('title', $card->card_name)

@section('content')
    <x-page-header
        :title="$card->card_name"
        :subtitle="$card->isCredit() ? 'Credit card ending in ' . $card->last_four : 'Debit card ending in ' . $card->last_four"
        :back="route('cards.index')"
        back-label="All cards"
    />

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.2fr)]">
        <div class="space-y-5">
            <x-card-tile
                :to="route('cards.show', $card)"
                :label="$card->isCredit() ? 'Credit card' : 'Debit card'"
                :number="$card->maskedNumber()"
                :network="$card->card_brand"
                :frozen="$card->frozen"
                :balance-label="$card->isCredit() ? 'Current balance' : 'Card status'"
                :balance="$card->isCredit() ? $card->current_balance : null"
            />

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <dl class="space-y-3 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Status</dt>
                        <dd>
                            <x-status-badge
                                :tone="$card->frozen ? 'warning' : ($card->status === 'active' ? 'success' : 'neutral')"
                                :label="$card->frozen ? 'Frozen' : ucfirst($card->status)"
                                dot
                            />
                        </dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Expires</dt>
                        <dd class="font-medium text-slate-900">{{ $card->expiryLabel() ?? '—' }}</dd>
                    </div>
                    @if($card->account)
                        <div class="flex items-center justify-between gap-3">
                            <dt class="text-slate-500">Linked account</dt>
                            <dd class="text-right font-medium text-slate-900">
                                <a href="{{ route('accounts.show', $card->account) }}" class="hover:text-brand-800 focus-ring">
                                    {{ $card->account->account_name }}
                                </a>
                            </dd>
                        </div>
                    @endif
                </dl>

                <div class="mt-4 flex flex-wrap gap-2 border-t border-slate-200 pt-4">
                    <form method="POST" action="{{ route('cards.toggleFrozen', $card) }}">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-semibold transition-colors focus-ring
                                       {{ $card->frozen
                                          ? 'bg-emerald-700 text-white hover:bg-emerald-800'
                                          : 'border border-slate-300 text-slate-700 hover:bg-slate-50' }}">
                            <x-icon name="lock" class="h-4 w-4" />
                            {{ $card->frozen ? 'Unfreeze card' : 'Freeze card' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('cards.pin', $card) }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                            PIN
                        </button>
                    </form>
                </div>

                <p class="mt-3 text-xs leading-relaxed text-slate-500">
                    Freezing a card blocks new purchases and withdrawals straight away. You can unfreeze it at any time.
                </p>
                <p class="mt-1.5 text-xs leading-relaxed text-slate-500">
                    This is a prototype. The freeze toggle is stored for demonstration, and no network card authorization
                    is affected.
                </p>
            </div>
        </div>

        <div class="space-y-5">
            @if($card->isCredit())
                <x-panel title="Credit summary" description="How much of your limit is in use">
                    <div class="space-y-4 p-5">
                        <x-progress
                            :value="$card->current_balance"
                            :max="$card->credit_limit"
                            label="Used"
                            tone="brand"
                            size="lg"
                        />

                        <dl class="grid grid-cols-2 gap-4 border-t border-slate-200 pt-4">
                            <div>
                                <dt class="text-xs text-slate-500">Available credit</dt>
                                <dd class="mt-0.5 text-lg font-semibold tabular-nums text-emerald-700" data-balance-sensitive>
                                    $<x-money :amount="$card->availableCredit()" :show-sign="false" />
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-slate-500">Credit limit</dt>
                                <dd class="mt-0.5 text-lg font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                                    $<x-money :amount="$card->credit_limit" :show-sign="false" />
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-slate-500">Minimum payment</dt>
                                <dd class="mt-0.5 text-sm font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                                    $<x-money :amount="$card->minimum_payment" :show-sign="false" />
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-slate-500">Payment due day</dt>
                                <dd class="mt-0.5 text-sm font-semibold text-slate-900">
                                    {{ $card->payment_due_day ? 'Day ' . $card->payment_due_day : '—' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </x-panel>
            @endif

            <x-panel title="Card controls" description="Turn features on or off">
                <form method="POST" action="{{ route('cards.controls', $card) }}" class="p-5">
                    @csrf
                    @method('PATCH')

                    <fieldset class="space-y-1">
                        <legend class="sr-only">Card controls</legend>

                        @php
                            $controls = [
                                ['name' => 'online_purchases', 'label' => 'Online purchases', 'hint' => 'Card payments on websites and apps'],
                                ['name' => 'international_purchases', 'label' => 'International purchases', 'hint' => 'Transactions billed in other currencies'],
                                ['name' => 'contactless', 'label' => 'Contactless payments', 'hint' => 'Tap to pay at contactless terminals'],
                                ['name' => 'atm_withdrawals', 'label' => 'ATM withdrawals', 'hint' => 'Cash withdrawals at ATMs'],
                            ];
                        @endphp

                        @foreach($controls as $control)
                            <label class="flex cursor-pointer items-start gap-3 rounded-lg px-2 py-2.5 transition-colors hover:bg-slate-50">
                                <input type="checkbox" name="{{ $control['name'] }}" value="1"
                                       @checked($card->{$control['name']})
                                       class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-600">
                                <span class="min-w-0">
                                    <span class="block text-sm font-medium text-slate-900">{{ $control['label'] }}</span>
                                    <span class="block text-xs text-slate-500">{{ $control['hint'] }}</span>
                                </span>
                            </label>
                        @endforeach
                    </fieldset>

                    <div class="mt-4 flex items-center justify-end gap-3 border-t border-slate-200 pt-4">
                        @if($card->frozen)
                            <p class="mr-auto text-xs text-amber-800">
                                Controls apply once the card is unfrozen.
                            </p>
                        @endif
                        <button type="submit" class="rounded-lg bg-brand-700 px-3.5 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                            Save controls
                        </button>
                    </div>
                </form>
            </x-panel>
        </div>
    </div>
@endsection
