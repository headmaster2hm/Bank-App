@extends('layouts.banking')

@section('title', 'Cards')

@section('content')
    <x-page-header
        title="Cards"
        subtitle="View your cards, adjust controls, and check balances."
    />

    @if($cards->isEmpty())
        <x-empty-state
            icon="card"
            title="No cards on file"
            description="Cards linked to your accounts will appear here with their controls and balances."
            action-label="View your accounts"
            :action-href="route('accounts.index')"
        />
    @else
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($cards as $card)
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <x-card-tile
                        :to="route('cards.show', $card)"
                        :label="$card->isCredit() ? 'Credit card' : 'Debit card'"
                        :number="$card->maskedNumber()"
                        :network="$card->card_brand"
                        :frozen="$card->frozen"
                        :balance-label="$card->isCredit() ? 'Balance' : 'Linked to'"
                        :balance="$card->isCredit() ? $card->current_balance : null"
                    />

                    <div class="mt-3.5 flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $card->card_name }}</p>
                            <p class="mt-0.5 text-xs text-slate-500">
                                @if($card->account)
                                    {{ $card->account->account_name }} · {{ $card->account->maskedNumber() }}
                                @else
                                    Not linked to an account
                                @endif
                            </p>
                        </div>
                        @if($card->expiryLabel())
                            <p class="shrink-0 text-xs text-slate-500">Exp {{ $card->expiryLabel() }}</p>
                        @endif
                    </div>

                    @if($card->isCredit())
                        <div class="mt-3">
                            <x-progress
                                :value="$card->current_balance"
                                :max="$card->credit_limit"
                                label="Credit used"
                                tone="brand"
                                size="sm"
                            />
                        </div>
                    @endif

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <a href="{{ route('cards.show', $card) }}"
                           class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                            Manage
                        </a>
                        <form method="POST" action="{{ route('cards.toggleFrozen', $card) }}">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-1 rounded-lg border px-2.5 py-1.5 text-xs font-semibold transition-colors focus-ring
                                           {{ $card->frozen
                                              ? 'border-emerald-300 bg-emerald-50 text-emerald-900 hover:bg-emerald-100'
                                              : 'border-slate-300 text-slate-700 hover:bg-slate-50' }}">
                                <x-icon name="lock" class="h-3.5 w-3.5" />
                                {{ $card->frozen ? 'Unfreeze' : 'Freeze' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
