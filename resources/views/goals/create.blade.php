@extends('layouts.banking')

@section('title', 'New goal')

@section('content')
    <x-page-header
        title="Create a savings goal"
        subtitle="Give your saving a name and a number, then track it."
        :back="route('goals.index')"
        back-label="All goals"
    />

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1.3fr)_minmax(0,1fr)]">
        <x-panel title="Goal details">
            <form method="POST" action="{{ route('goals.store') }}" class="space-y-5 p-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-800">Goal name</label>
                    <input id="name" name="name" type="text" required maxlength="80" value="{{ old('name') }}"
                           placeholder="Emergency fund"
                           class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                </div>

                <div>
                    <label for="purpose" class="block text-sm font-medium text-slate-800">
                        What is it for? <span class="font-normal text-slate-500">(optional)</span>
                    </label>
                    <input id="purpose" name="purpose" type="text" maxlength="160" value="{{ old('purpose') }}"
                           placeholder="Six months of expenses"
                           class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="target_amount" class="block text-sm font-medium text-slate-800">Target amount</label>
                        <div class="relative mt-1.5">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-500">$</span>
                            <input id="target_amount" name="target_amount" type="number" step="0.01" min="1" required
                                   value="{{ old('target_amount') }}"
                                   class="w-full rounded-lg border border-slate-300 py-2 pl-7 pr-3 text-sm tabular-nums focus:border-brand-500 focus-ring">
                        </div>
                    </div>

                    <div>
                        <label for="current_amount" class="block text-sm font-medium text-slate-800">
                            Already saved <span class="font-normal text-slate-500">(optional)</span>
                        </label>
                        <div class="relative mt-1.5">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-500">$</span>
                            <input id="current_amount" name="current_amount" type="number" step="0.01" min="0"
                                   value="{{ old('current_amount', '0.00') }}"
                                   class="w-full rounded-lg border border-slate-300 py-2 pl-7 pr-3 text-sm tabular-nums focus:border-brand-500 focus-ring">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="target_date" class="block text-sm font-medium text-slate-800">
                        Target date <span class="font-normal text-slate-500">(optional)</span>
                    </label>
                    <input id="target_date" name="target_date" type="date" value="{{ old('target_date') }}"
                           min="{{ now()->addDay()->toDateString() }}"
                           class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                    <p class="mt-1.5 text-xs text-slate-500">Leave blank for an open-ended goal.</p>
                </div>

                <div>
                    <label for="account_id" class="block text-sm font-medium text-slate-800">
                        Keep funds in <span class="font-normal text-slate-500">(optional)</span>
                    </label>
                    <select id="account_id" name="account_id"
                            class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white py-2 text-sm focus:border-brand-500 focus-ring">
                        <option value="">Choose later</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" @selected(old('account_id') == $account->id)>
                                {{ $account->account_name }} ({{ $account->maskedNumber() }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-4">
                    <a href="{{ route('goals.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 focus-ring">
                        Cancel
                    </a>
                    <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                        Create goal
                    </button>
                </div>
            </form>
        </x-panel>

        <x-panel title="How goals work">
            <div class="space-y-3 p-5 text-sm text-slate-600">
                <p>A goal tracks a target rather than moving your money into a separate account. Contributions are recorded against your chosen account so you can see the progress.</p>
                <p>You can cancel a goal at any time. Funds you have already contributed stay exactly where they are.</p>
                <p>Reaching your target marks the goal complete. You can still contribute to it if plans change.</p>
            </div>
        </x-panel>
    </div>
@endsection
