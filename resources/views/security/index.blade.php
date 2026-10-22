@extends('layouts.banking')

@section('title', 'Security')

@section('content')
    <x-page-header
        title="Security centre"
        subtitle="Review how your account is protected and where it has been used."
    />

    <div class="grid gap-4 sm:grid-cols-3">
        <x-stat
            label="Two-step verification"
            :value="$preference?->two_factor_enabled ? 'On' : 'Off'"
            icon="shield"
            :tone="$preference?->two_factor_enabled ? 'success' : 'muted'"
        />
        <x-stat label="Trusted devices" :value="$devices->count()" icon="cog" />
        <x-stat
            label="Activity to review"
            :value="$suspiciousCount"
            icon="alert"
            :tone="$suspiciousCount > 0 ? 'muted' : 'success'"
        />
    </div>

    @if($suspiciousCount > 0)
        <div class="mt-5">
            <x-alert tone="warning" icon="alert" title="We noticed activity that needs your attention">
                {{ $suspiciousCount }} {{ Str::plural('event', $suspiciousCount) }} on this list could not be matched to a
                recognised device. If any of it was not you, change your password and contact us straight away.
                <x-slot:actions>
                    <a href="{{ route('messages.create') }}"
                       class="inline-flex items-center gap-1 rounded-lg border border-amber-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-amber-900 transition-colors hover:bg-amber-100 focus-ring">
                        Contact SecureBank
                    </a>
                </x-slot:actions>
            </x-alert>
        </div>
    @endif

    <div class="mt-5 grid gap-5 lg:grid-cols-2">
        <div class="space-y-5">
            <x-panel title="Two-step verification" description="Require a code at sign-in">
                <div class="p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <x-status-badge
                                    :tone="$preference?->two_factor_enabled ? 'success' : 'warning'"
                                    :label="$preference?->two_factor_enabled ? 'Enabled' : 'Not enabled'"
                                    dot
                                />
                            </div>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                @if($preference?->two_factor_enabled)
                                    Marked as enabled for this demonstration account.
                                @else
                                    Turning this on makes an account takeover much harder, even if someone has your password.
                                @endif
                            </p>
                            <p class="mt-2 text-xs leading-relaxed text-slate-500">
                                Prototype: this toggle records a preference only. No verification code is issued and
                                sign-in is not challenged in this build.
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('security.twoFactor') }}" class="mt-4 border-t border-slate-200 pt-4">
                        @csrf
                        <button type="submit"
                                class="w-full rounded-lg px-3 py-2 text-sm font-semibold transition-colors focus-ring
                                       {{ $preference?->two_factor_enabled
                                          ? 'border border-slate-300 text-slate-700 hover:bg-slate-50'
                                          : 'bg-brand-700 text-white hover:bg-brand-800' }}">
                            {{ $preference?->two_factor_enabled ? 'Turn two-step verification off' : 'Turn two-step verification on' }}
                        </button>
                    </form>
                </div>
            </x-panel>

            <x-panel title="Change password" description="Use at least 10 characters with letters and numbers">
                <form method="POST" action="{{ route('security.password') }}" class="space-y-4 p-5">
                    @csrf

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-slate-800">Current password</label>
                        <input id="current_password" name="current_password" type="password" required autocomplete="current-password"
                               class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-800">New password</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password" minlength="10"
                               class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-800">Confirm new password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" minlength="10"
                               class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                    </div>

                    <div class="flex items-center justify-end border-t border-slate-200 pt-4">
                        <button type="submit" class="rounded-lg bg-brand-700 px-3.5 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                            Change password
                        </button>
                    </div>
                </form>
            </x-panel>
        </div>

        <div class="space-y-5">
            <x-panel title="Trusted devices" description="Devices you have signed in from">
                @if($devices->isNotEmpty())
                    <ul class="divide-y divide-slate-100">
                        @foreach($devices as $device)
                            <li class="flex items-center gap-3 px-5 py-3.5">
                                <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-50 text-slate-500 ring-1 ring-slate-200">
                                    <x-icon :name="$device->device_type === 'mobile' ? 'activity' : 'cog'" class="h-4 w-4" />
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <p class="truncate text-sm font-semibold text-slate-900">{{ $device->device_name }}</p>
                                        @if($device->isCurrent())
                                            <x-status-badge tone="success" label="This device" />
                                        @endif
                                    </div>
                                    <p class="mt-0.5 text-xs text-slate-500">
                                        {{ $device->location }}
                                        @if($device->last_used_at)
                                            · last used {{ $device->last_used_at->diffForHumans() }}
                                        @endif
                                    </p>
                                </div>
                                @unless($device->isCurrent())
                                    <form method="POST" action="{{ route('security.devices.revoke', $device->id) }}" class="shrink-0"
                                          onsubmit="return confirm('Remove this trusted device?');">
                                        @csrf
                                        <button type="submit" class="rounded-lg px-2.5 py-1.5 text-xs font-semibold text-slate-600 transition-colors hover:bg-slate-100 hover:text-rose-700 focus-ring">
                                            Remove
                                        </button>
                                    </form>
                                @endunless
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-5">
                        <x-empty-state icon="cog" title="No trusted devices" description="Devices you sign in from will be listed here." compact />
                    </div>
                @endif
            </x-panel>

            <x-panel title="Recent activity" description="Security events on your account">
                @if($events->isNotEmpty())
                    <ul class="divide-y divide-slate-100">
                        @foreach($events as $event)
                            <li class="flex items-start gap-3 px-5 py-3">
                                <span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg ring-1
                                             {{ match($event->tone()) {
                                                 'success' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                                 'warning' => 'bg-amber-50 text-amber-700 ring-amber-200',
                                                 default => 'bg-slate-50 text-slate-500 ring-slate-200',
                                             } }}">
                                    <x-icon :name="$event->is_suspicious ? 'alert' : 'check'" class="h-4 w-4" />
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-slate-900">{{ $event->title }}</p>
                                    <p class="mt-0.5 text-xs text-slate-500">
                                        {{ $event->typeLabel() }}
                                        @if($event->location) · {{ $event->location }} @endif
                                        @if($event->ip_address) · {{ $event->ip_address }} @endif
                                    </p>
                                </div>
                                <div class="shrink-0 text-right">
                                    <p class="text-xs text-slate-500">{{ $event->occurred_at->diffForHumans() }}</p>
                                    @if($event->is_suspicious)
                                        <x-status-badge tone="danger" label="Review" />
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-5">
                        <x-empty-state icon="activity" title="No activity recorded" description="Sign-ins and security changes will appear here." compact />
                    </div>
                @endif
            </x-panel>
        </div>
    </div>
@endsection
