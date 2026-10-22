@extends('layouts.banking')

@section('title', 'Search')

@section('content')
    <x-page-header
        title="Search"
        :subtitle="$query !== '' ? 'Results for “' . $query . '”' : 'Find accounts, transactions, features, and help.'"
    />

    <form action="{{ route('search') }}" method="GET" role="search" class="mb-6">
        <label for="search-page" class="sr-only">Search your accounts and help content</label>
        <div class="relative max-w-2xl">
            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                <x-icon name="search" class="h-5 w-5" />
            </span>
            <input id="search-page" name="q" type="search" value="{{ $query }}" autofocus
                   placeholder="Try “coffee”, “savings”, or “transfer”"
                   class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-24 text-sm shadow-sm placeholder:text-slate-400 focus:border-brand-500 focus-ring">
            <button type="submit" class="absolute inset-y-1.5 right-1.5 rounded-lg bg-brand-700 px-3.5 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                Search
            </button>
        </div>
    </form>

    @if($query === '')
        <x-empty-state
            icon="search"
            title="Search your banking"
            description="Look up a transaction by merchant or reference, find an account, jump to a feature, or read related help content."
        />
    @elseif(mb_strlen($query) < 2)
        <x-alert tone="info" icon="info" title="Keep typing">
            Enter at least two characters to search.
        </x-alert>
    @elseif($total === 0)
        <x-empty-state
            icon="search"
            title="No results for “{{ $query }}”"
            description="Check the spelling, try a shorter word, or browse the features on your dashboard."
            action-label="Back to dashboard"
            :action-href="route('dashboard')"
        />
    @else
        <p class="mb-4 text-sm text-slate-600" role="status">
            {{ $total }} {{ Str::plural('result', $total) }} for “{{ $query }}”
        </p>

        <div class="space-y-5">
            @if($results['features']->isNotEmpty())
                <x-panel title="Features" description="Places in online banking">
                    <ul class="divide-y divide-slate-100">
                        @foreach($results['features'] as $feature)
                            <li>
                                <a href="{{ route($feature['route']) }}" class="group flex items-center gap-3 px-5 py-3 transition-colors hover:bg-slate-50 focus-ring">
                                    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-700 ring-1 ring-brand-100">
                                        <x-icon :name="$feature['icon']" class="h-4 w-4" />
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-semibold text-slate-900">{{ $feature['label'] }}</span>
                                        <span class="block truncate text-xs text-slate-500">{{ $feature['group'] }}{{ isset($feature['description']) ? ' · ' . $feature['description'] : '' }}</span>
                                    </span>
                                    <x-icon name="chevron-right" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-brand-700" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </x-panel>
            @endif

            @if($results['accounts']->isNotEmpty())
                <x-panel title="Accounts" description="Accounts matching your search">
                    <div class="grid gap-3 p-5 sm:grid-cols-2">
                        @foreach($results['accounts'] as $account)
                            <x-account-card :account="$account" />
                        @endforeach
                    </div>
                </x-panel>
            @endif

            @if($results['transactions']->isNotEmpty())
                <x-panel title="Transactions" description="Activity matching your search" :href="route('transactions.index')" link-label="All activity">
                    <div class="divide-y divide-slate-100 p-2">
                        @foreach($results['transactions'] as $transaction)
                            <x-transaction-row :transaction="$transaction" show-account />
                        @endforeach
                    </div>
                </x-panel>
            @endif

            @if($results['help']->isNotEmpty())
                <x-panel title="Help and information" description="Guides on the public site">
                    <ul class="divide-y divide-slate-100">
                        @foreach($results['help'] as $page)
                            <li>
                                <a href="{{ \App\Support\MarketingCatalog::url($page['title']) }}"
                                   class="group flex items-start gap-3 px-5 py-3 transition-colors hover:bg-slate-50 focus-ring">
                                    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-50 text-slate-500 ring-1 ring-slate-200">
                                        <x-icon name="document" class="h-4 w-4" />
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-semibold text-slate-900">{{ $page['title'] }}</span>
                                        <span class="mt-0.5 block text-xs leading-relaxed text-slate-500">{{ Str::limit($page['lede'], 130) }}</span>
                                    </span>
                                    <x-icon name="external" class="h-4 w-4 shrink-0 text-slate-400 group-hover:text-brand-700" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </x-panel>
            @endif
        </div>
    @endif
@endsection
