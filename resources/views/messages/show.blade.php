@extends('layouts.banking')

@section('title', $thread->subject)

@section('content')
    <x-page-header
        :title="$thread->subject"
        :subtitle="'Conversation with SecureBank · ' . ($thread->isOpen() ? 'Open' : 'Closed')"
        :back="route('messages.index')"
        back-label="All messages"
    />

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)]">
        <x-panel>
            <ol class="space-y-4 p-5">
                @foreach($messages as $message)
                    <li class="flex {{ $message->isFromCustomer() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[85%] sm:max-w-[75%]">
                            <div class="rounded-xl px-4 py-3 text-sm leading-relaxed
                                        {{ $message->isFromCustomer()
                                           ? 'bg-brand-700 text-white'
                                           : 'border border-slate-200 bg-slate-50 text-slate-800' }}">
                                {!! nl2br(e($message->body)) !!}
                            </div>
                            <p class="mt-1 px-1 text-xs text-slate-500">
                                {{ $message->isFromCustomer() ? 'You' : 'SecureBank support' }}
                                · <time datetime="{{ $message->sent_at->toIso8601String() }}">{{ $message->sent_at->isoFormat('MMM D, h:mm A') }}</time>
                            </p>
                        </div>
                    </li>
                @endforeach
            </ol>

            <div class="border-t border-slate-200 p-5">
                <form method="POST" action="{{ route('messages.reply', $thread) }}" class="space-y-3">
                    @csrf
                    <label for="reply" class="block text-sm font-medium text-slate-800">Reply</label>
                    <textarea id="reply" name="body" rows="4" required maxlength="4000"
                              placeholder="Write your reply"
                              class="w-full rounded-lg border border-slate-300 py-2 text-sm leading-relaxed focus:border-brand-500 focus-ring">{{ old('body') }}</textarea>
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-xs text-slate-500">Do not include passwords, PINs, or full card numbers.</p>
                        <button type="submit" class="rounded-lg bg-brand-700 px-3.5 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                            Send reply
                        </button>
                    </div>
                </form>
            </div>
        </x-panel>

        <x-panel title="About this conversation">
            <dl class="space-y-3 p-5 text-sm">
                <div class="flex items-center justify-between gap-3">
                    <dt class="text-slate-500">Category</dt>
                    <dd class="font-semibold text-slate-900">{{ ucfirst($thread->category) }}</dd>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <dt class="text-slate-500">Status</dt>
                    <dd>
                        <x-status-badge :tone="$thread->isOpen() ? 'brand' : 'neutral'" :label="$thread->isOpen() ? 'Open' : 'Closed'" dot />
                    </dd>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <dt class="text-slate-500">Messages</dt>
                    <dd class="font-semibold tabular-nums text-slate-900">{{ $messages->count() }}</dd>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <dt class="text-slate-500">Last activity</dt>
                    <dd class="font-semibold text-slate-900">{{ $thread->last_message_at?->diffForHumans() ?? '—' }}</dd>
                </div>
            </dl>
        </x-panel>
    </div>
@endsection
