@extends('layouts.banking')

@section('title', 'New message')

@section('content')
    <x-page-header
        title="Start a secure message"
        subtitle="We usually reply within one business day."
        :back="route('messages.index')"
        back-label="All messages"
    />

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1.3fr)_minmax(0,1fr)]">
        <x-panel title="Your message">
            <form method="POST" action="{{ route('messages.store') }}" class="space-y-5 p-5">
                @csrf

                <div>
                    <label for="subject" class="block text-sm font-medium text-slate-800">Subject</label>
                    <input id="subject" name="subject" type="text" required maxlength="120" value="{{ old('subject') }}"
                           placeholder="Question about my savings account"
                           class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm focus:border-brand-500 focus-ring">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-slate-800">What is this about?</label>
                    <select id="category" name="category" required
                            class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white py-2 text-sm focus:border-brand-500 focus-ring">
                        @foreach([
                            'general' => 'General question',
                            'accounts' => 'My accounts',
                            'loans' => 'Loans',
                            'cards' => 'Cards',
                            'security' => 'Security',
                            'fraud' => 'Something looks wrong',
                        ] as $value => $label)
                            <option value="{{ $value }}" @selected(old('category') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="body" class="block text-sm font-medium text-slate-800">Message</label>
                    <textarea id="body" name="body" rows="7" required minlength="10" maxlength="4000"
                              placeholder="Tell us what you need. Please do not include your full card number, PIN, or password."
                              class="mt-1.5 w-full rounded-lg border border-slate-300 py-2 text-sm leading-relaxed focus:border-brand-500 focus-ring">{{ old('body') }}</textarea>
                    <p class="mt-1.5 text-xs text-slate-500">
                        Never share passwords, PINs, or full card numbers. SecureBank will never ask for them.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-4">
                    <a href="{{ route('messages.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 focus-ring">
                        Cancel
                    </a>
                    <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                        Send message
                    </button>
                </div>
            </form>
        </x-panel>

        <x-panel title="If something is wrong">
            <div class="space-y-3 p-5 text-sm text-slate-600">
                <p>If you see a payment or sign-in you do not recognise, change your password immediately and then tell us here.</p>
                <p>Choose "Something looks wrong" as the category so your message reaches the right team quickly.</p>
                <p>SecureBank staff will never ask for your password or a one-time code over a message.</p>
            </div>
        </x-panel>
    </div>
@endsection
