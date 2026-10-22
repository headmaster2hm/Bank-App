@extends('layouts.banking')

@section('title', 'Notifications')

@section('content')
    <x-page-header
        title="Notifications"
        subtitle="Security alerts, payments, and account updates."
    >
        <x-slot:actions>
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-ring">
                        <x-icon name="check" class="h-4 w-4" />
                        Mark all read
                    </button>
                </form>
            @endif
        </x-slot:actions>
    </x-page-header>

    <div class="mb-5 flex flex-wrap gap-2">
        <a href="{{ route('notifications.index') }}"
           class="rounded-lg px-3 py-1.5 text-sm font-semibold transition-colors focus-ring {{ $filter === '' ? 'bg-brand-700 text-white' : 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50' }}">
            All
        </a>
        <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
           class="rounded-lg px-3 py-1.5 text-sm font-semibold transition-colors focus-ring {{ $filter === 'unread' ? 'bg-brand-700 text-white' : 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50' }}">
            Unread
            @if($unreadCount > 0)
                <span class="ml-1 tabular-nums opacity-80">({{ $unreadCount }})</span>
            @endif
        </a>
        <a href="{{ route('notifications.index', ['filter' => 'read']) }}"
           class="rounded-lg px-3 py-1.5 text-sm font-semibold transition-colors focus-ring {{ $filter === 'read' ? 'bg-brand-700 text-white' : 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50' }}">
            Read
        </a>
    </div>

    @if($notifications->isEmpty())
        <x-empty-state
            icon="bell"
            :title="$filter === 'unread' ? 'Nothing unread' : 'No notifications yet'"
            :description="$filter === 'unread'
                ? 'You are all caught up. New alerts will appear here.'
                : 'Alerts about payments, security, and account activity will show up here.'"
            action-label="Back to dashboard"
            :action-href="route('dashboard')"
        />
    @else
        <x-panel>
            <ul class="divide-y divide-slate-100">
                @foreach($notifications as $notification)
                    <li class="{{ $notification->isRead() ? '' : 'bg-brand-50/40' }}">
                        <div class="flex items-start gap-4 px-5 py-4">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg ring-1
                                         {{ match($notification->tone()) {
                                             'warning' => 'bg-amber-50 text-amber-700 ring-amber-200',
                                             'success' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                             'info' => 'bg-sky-50 text-sky-700 ring-sky-200',
                                             default => 'bg-slate-50 text-slate-600 ring-slate-200',
                                         } }}">
                                <x-icon :name="$notification->category === 'security' ? 'shield' : 'bell'" class="h-5 w-5" />
                            </span>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="text-sm font-semibold text-slate-900">{{ $notification->title }}</h2>
                                    @unless($notification->isRead())
                                        <x-status-badge tone="brand" label="New" />
                                    @endunless
                                </div>
                                <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $notification->body }}</p>
                                <p class="mt-1.5 text-xs text-slate-500">
                                    <x-status-badge :tone="$notification->tone() === 'neutral' ? 'neutral' : $notification->tone()" :label="$notification->categoryLabel()" />
                                    <span class="ml-1">{{ $notification->created_at->diffForHumans() }}</span>
                                </p>
                            </div>

                            <div class="flex shrink-0 flex-col items-end gap-2">
                                @if($notification->action_label && $notification->action_url)
                                    <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                        @csrf
                                        <button type="submit" class="rounded-lg bg-brand-700 px-2.5 py-1.5 text-xs font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                                            {{ $notification->action_label }}
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('notifications.destroy', $notification) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg px-2.5 py-1.5 text-xs font-semibold text-slate-500 transition-colors hover:bg-slate-100 hover:text-rose-700 focus-ring">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </x-panel>
    @endif
@endsection
