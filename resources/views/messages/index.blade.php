@extends('layouts.banking')

@section('title', 'Messages')

@section('content')
    <x-page-header
        title="Secure messages"
        subtitle="Conversations with SecureBank, kept on your account."
    >
        <x-slot:actions>
            <a href="{{ route('messages.create') }}"
               class="inline-flex items-center gap-1.5 rounded-lg bg-brand-700 px-3 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                <x-icon name="plus" class="h-4 w-4" />
                New message
            </a>
        </x-slot:actions>
    </x-page-header>

    @if($threads->isEmpty())
        <x-empty-state
            icon="chat"
            title="No messages yet"
            description="Send SecureBank a secure message and the reply will appear here."
            action-label="Start a conversation"
            :action-href="route('messages.create')"
        />
    @else
        <x-panel :title="Str::plural('Conversation', $threads->count())">
            <ul class="divide-y divide-slate-100">
                @foreach($threads as $thread)
                    <li>
                        <a href="{{ route('messages.show', $thread) }}"
                           class="group flex items-start gap-4 px-5 py-4 transition-colors hover:bg-slate-50 focus-ring">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg ring-1
                                         {{ $thread->isOpen() ? 'bg-brand-50 text-brand-700 ring-brand-200' : 'bg-slate-50 text-slate-500 ring-slate-200' }}">
                                <x-icon name="chat" class="h-5 w-5" />
                            </span>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="truncate text-sm font-semibold text-slate-900">{{ $thread->subject }}</p>
                                    <x-status-badge
                                        :tone="$thread->isOpen() ? 'brand' : 'neutral'"
                                        :label="$thread->isOpen() ? 'Open' : 'Closed'"
                                    />
                                </div>
                                <p class="mt-1 truncate text-sm text-slate-500">{{ $thread->preview() }}</p>
                            </div>

                            <p class="shrink-0 text-xs text-slate-500">
                                {{ $thread->last_message_at?->diffForHumans() }}
                            </p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </x-panel>
    @endif
@endsection
