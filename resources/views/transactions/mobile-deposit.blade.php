@extends('layouts.banking')

@section('title', 'Mobile deposit')

@section('content')
    <x-page-header
        title="Deposit a cheque by photo"
        subtitle="Send us a picture of the front of your cheque and we will credit your account."
        :back="route('dashboard')"
        back-label="Back to dashboard"
    />

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)]">
        <x-panel title="Take the photo">
            <div class="space-y-5 p-5">
                <div class="rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                    <span class="mx-auto mb-3 inline-flex h-12 w-12 items-center justify-center rounded-full bg-white text-slate-500 ring-1 ring-slate-200">
                        <x-icon name="plus" class="h-6 w-6" />
                    </span>
                    <p class="text-sm font-semibold text-slate-900">Cheque photo upload</p>
                    <p class="mx-auto mt-1.5 max-w-sm text-sm leading-relaxed text-slate-600">
                        Camera capture is not available in this prototype. On a supported device you would photograph the
                        front of the cheque, confirm the amount, and choose the account to credit.
                    </p>
                    <p class="mt-4 text-xs text-slate-500">
                        This is a prototype. No cheque is captured and no funds are moved. Hold times and deposit
                        availability would be shown here once mobile capture is connected.
                    </p>
                </div>

                <div>
                    <label for="deposit_account" class="block text-sm font-medium text-slate-800">Deposit into</label>
                    <select id="deposit_account"
                            class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white py-2 text-sm focus:border-brand-500 focus-ring">
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->account_name }} ({{ $account->maskedNumber() }})</option>
                        @endforeach
                    </select>
                </div>

                <a href="{{ route('deposit') }}"
                   class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-brand-700 px-3 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                    Deposit cash or cheque instead
                </a>
            </div>
        </x-panel>

        <x-panel title="Before you photograph">
            <ul class="space-y-2.5 p-5 text-sm text-slate-600">
                <li class="flex gap-2.5">
                    <x-icon name="check-circle" class="h-4 w-4 shrink-0 text-emerald-600" />
                    Write your signature and the amount in the usual place.
                </li>
                <li class="flex gap-2.5">
                    <x-icon name="check-circle" class="h-4 w-4 shrink-0 text-emerald-600" />
                    Make sure the whole cheque fits in the frame with a flat surface and even light.
                </li>
                <li class="flex gap-2.5">
                    <x-icon name="check-circle" class="h-4 w-4 shrink-0 text-emerald-600" />
                    Hold the cheque flat so the corners are visible and the image is not blurry.
                </li>
                <li class="flex gap-2.5">
                    <x-icon name="alert" class="h-4 w-4 shrink-0 text-amber-600" />
                    Endorsing a cheque to SecureBank. Write "For mobile deposit only" above the signature line.
                </li>
            </ul>
        </x-panel>
    </div>
@endsection
