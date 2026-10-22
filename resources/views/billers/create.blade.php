@extends('layouts.banking')

@section('title', 'Add a biller')

@section('content')
    <x-page-header
        title="Add a biller"
        subtitle="Save a company so you can pay it quickly next time."
        :back="route('billers.index')"
        back-label="All billers"
    />

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1.3fr)_minmax(0,1fr)]">
        <x-panel title="Biller details">
            <form method="POST" action="{{ route('billers.store') }}" class="space-y-5 p-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-800">Company name</label>
                    <input id="name" name="name" type="text" required maxlength="100" value="{{ old('name') }}"
                           placeholder="Metro Electric"
                           class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="category" class="block text-sm font-medium text-slate-800">Category</label>
                        <select id="category" name="category"
                                class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white py-2 text-sm focus:border-brand-500 focus-ring">
                            <option value="">Select a category</option>
                            @foreach(['Utilities', 'Housing', 'Insurance', 'Health', 'Credit card', 'Loan', 'Other'] as $category)
                                <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="account_reference" class="block text-sm font-medium text-slate-800">
                            Account number <span class="font-normal text-slate-500">(optional)</span>
                        </label>
                        <input id="account_reference" name="account_reference" type="text" maxlength="60" value="{{ old('account_reference') }}"
                               class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="amount_due" class="block text-sm font-medium text-slate-800">Amount due</label>
                        <div class="relative mt-1.5">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-500">$</span>
                            <input id="amount_due" name="amount_due" type="number" step="0.01" min="0" required
                                   value="{{ old('amount_due') }}"
                                   class="w-full rounded-lg border border-slate-300 py-2 pl-7 pr-3 text-sm tabular-nums focus:border-brand-500 focus-ring">
                        </div>
                    </div>

                    <div>
                        <label for="due_date" class="block text-sm font-medium text-slate-800">Due date</label>
                        <input id="due_date" name="due_date" type="date" required value="{{ old('due_date') }}"
                               class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                    </div>
                </div>

                <div>
                    <label for="account_id" class="block text-sm font-medium text-slate-800">
                        Pay from <span class="font-normal text-slate-500">(optional)</span>
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

                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                    <input type="checkbox" name="autopay" value="1" @checked(old('autopay'))
                           class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-600">
                    <span>
                        <span class="block text-sm font-medium text-slate-900">Turn on monthly autopay</span>
                        <span class="block text-xs text-slate-500">Pay this biller automatically once a month while it is enabled.</span>
                    </span>
                </label>

                <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-4">
                    <a href="{{ route('billers.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 focus-ring">
                        Cancel
                    </a>
                    <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                        Save biller
                    </button>
                </div>
            </form>
        </x-panel>

        <x-panel title="About bill pay">
            <div class="space-y-3 p-5 text-sm text-slate-600">
                <p>Payments are withdrawn from the account you choose at the time of payment, not when you save the biller.</p>
                <p>Autopay runs monthly on the due date shown. Turn it off at any time and the biller stays saved.</p>
                <p>Never store your biller's password in these fields. SecureBank only needs enough detail to identify the account you are paying.</p>
            </div>
        </x-panel>
    </div>
@endsection
