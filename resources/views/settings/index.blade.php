@extends('layouts.banking')

@section('title', 'Settings')

@section('content')
    <x-page-header
        title="Settings"
        subtitle="Your profile, contact details, and banking preferences."
    />

    <div class="grid gap-5 lg:grid-cols-2">
        <x-panel title="Profile" description="How you appear in SecureBank">
            <form method="POST" action="{{ route('settings.profile') }}" class="space-y-4 p-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-800">Full name</label>
                    <input id="name" name="name" type="text" required maxlength="120" value="{{ old('name', auth()->user()->name) }}"
                           class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-800">Email address</label>
                    <input id="email" name="email" type="email" required maxlength="180" value="{{ old('email', auth()->user()->email) }}"
                           class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-slate-800">Mobile number</label>
                    <input id="phone" name="phone" type="tel" maxlength="40" value="{{ old('phone', auth()->user()->phone) }}"
                           class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                    <p class="mt-1.5 text-xs text-slate-500">Used for security codes and fraud alerts.</p>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-slate-800">Mailing address</label>
                    <input id="address" name="address" type="text" maxlength="180" value="{{ old('address', auth()->user()->address) }}"
                           class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                </div>

                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-slate-800">Date of birth</label>
                    <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', auth()->user()->date_of_birth?->toDateString()) }}"
                           class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                </div>

                <fieldset class="space-y-3 border-t border-slate-200 pt-4">
                    <legend class="text-sm font-semibold text-slate-900">Change email or password</legend>
                    <p class="text-xs text-slate-500">Changing your sign-in details needs your current password as a check.</p>

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-slate-800">Current password</label>
                        <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                               class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-slate-800">New password (optional)</label>
                        <input id="new_password" name="password" type="password" autocomplete="new-password" minlength="10"
                               class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-slate-800">Confirm new password</label>
                        <input id="new_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="10"
                               class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                    </div>
                </fieldset>

                <div class="flex items-center justify-end border-t border-slate-200 pt-4">
                    <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                        Save profile
                    </button>
                </div>
            </form>
        </x-panel>

        <div class="space-y-5">
            <x-panel title="Preferences" description="Alerts, statements, and balance display">
                <form method="POST" action="{{ route('settings.preferences') }}" class="space-y-4 p-5">
                    @csrf
                    @method('PATCH')

                    <fieldset class="space-y-1">
                        <legend class="sr-only">Display preferences</legend>
                        <label class="flex cursor-pointer items-start gap-3 rounded-lg px-2 py-2.5 hover:bg-slate-50">
                            <input type="checkbox" name="balances_visible_by_default" value="1"
                                   @checked(old('balances_visible_by_default', $preference?->balances_visible_by_default))
                                   class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-600">
                            <span>
                                <span class="block text-sm font-medium text-slate-900">Show balances by default</span>
                                <span class="block text-xs text-slate-500">Balances are always masked with the eye control on this device.</span>
                            </span>
                        </label>
                    </fieldset>

                    <fieldset class="space-y-1 border-t border-slate-200 pt-4">
                        <legend class="text-sm font-semibold text-slate-900">Alerts</legend>

                        <label class="flex cursor-pointer items-start gap-3 rounded-lg px-2 py-2.5 hover:bg-slate-50">
                            <input type="checkbox" name="login_alerts" value="1" @checked($preference?->login_alerts)
                                   class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-600">
                            <span>
                                <span class="block text-sm font-medium text-slate-900">New sign-in alerts</span>
                                <span class="block text-xs text-slate-500">Tell me when my account is used from a new device.</span>
                            </span>
                        </label>

                        <label class="flex cursor-pointer items-start gap-3 rounded-lg px-2 py-2.5 hover:bg-slate-50">
                            <input type="checkbox" name="payment_alerts" value="1" @checked($preference?->payment_alerts)
                                   class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-600">
                            <span>
                                <span class="block text-sm font-medium text-slate-900">Payment alerts</span>
                                <span class="block text-xs text-slate-500">Confirm incoming and outgoing payments.</span>
                            </span>
                        </label>

                        <label class="flex cursor-pointer items-start gap-3 rounded-lg px-2 py-2.5 hover:bg-slate-50">
                            <input type="checkbox" name="promotional_emails" value="1" @checked($preference?->promotional_emails)
                                   class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-600">
                            <span>
                                <span class="block text-sm font-medium text-slate-900">Offers and product news</span>
                                <span class="block text-xs text-slate-500">Off by default. Turning this on opts you in to marketing email.</span>
                            </span>
                        </label>
                    </fieldset>

                    <fieldset class="space-y-4 border-t border-slate-200 pt-4">
                        <legend class="text-sm font-semibold text-slate-900">Statements</legend>

                        <label class="flex cursor-pointer items-start gap-3 rounded-lg px-2 py-2.5 hover:bg-slate-50">
                            <input type="checkbox" name="paperless_statements" value="1" @checked($preference?->paperless_statements)
                                   class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-700 focus:ring-brand-600">
                            <span>
                                <span class="block text-sm font-medium text-slate-900">Paperless delivery</span>
                                <span class="block text-xs text-slate-500">Statements appear in Documents instead of being mailed.</span>
                            </span>
                        </label>

                        <div>
                            <label for="statement_format" class="block text-sm font-medium text-slate-800">Preferred format</label>
                            <select id="statement_format" name="statement_format"
                                    class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white py-2 text-sm focus:border-brand-500 focus-ring">
                                <option value="pdf" @selected(($preference?->statement_format ?? 'pdf') === 'pdf')>PDF document</option>
                                <option value="html" @selected(($preference?->statement_format ?? 'pdf') === 'html')>Web page</option>
                            </select>
                        </div>

                        <div>
                            <label for="time_zone" class="block text-sm font-medium text-slate-800">Time zone</label>
                            <select id="time_zone" name="time_zone"
                                    class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white py-2 text-sm focus:border-brand-500 focus-ring">
                                @foreach(['America/New_York' => 'Eastern', 'America/Chicago' => 'Central', 'America/Denver' => 'Mountain', 'America/Los_Angeles' => 'Pacific', 'UTC' => 'UTC'] as $zone => $label)
                                    <option value="{{ $zone }}" @selected(($preference?->time_zone ?? 'UTC') === $zone)>{{ $label }} ({{ $zone }})</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>

                    <div class="flex items-center justify-end border-t border-slate-200 pt-4">
                        <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                            Save preferences
                        </button>
                    </div>
                </form>
            </x-panel>

            <x-panel title="Your accounts">
                <ul class="divide-y divide-slate-100">
                    @foreach($accounts as $account)
                        <li class="flex items-center justify-between gap-3 px-5 py-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-slate-900">{{ $account->account_name }}</p>
                                <p class="text-xs text-slate-500">{{ ucfirst($account->account_type) }} · {{ $account->maskedNumber() }}</p>
                            </div>
                            <p class="shrink-0 text-sm font-semibold tabular-nums text-slate-900" data-balance-sensitive>
                                $<x-money :amount="$account->balance" :show-sign="false" />
                            </p>
                        </li>
                    @endforeach
                </ul>
            </x-panel>
        </div>
    </div>
@endsection
