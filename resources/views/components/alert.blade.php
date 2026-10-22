@props([
    'tone' => 'success',
    'title',
    'body' => null,
    'icon' => 'info',
])

@php
    $tones = [
        'success' => ['wrap' => 'border-emerald-200 bg-emerald-50', 'icon' => 'text-emerald-700', 'title' => 'text-emerald-900', 'body' => 'text-emerald-800'],
        'error' => ['wrap' => 'border-rose-200 bg-rose-50', 'icon' => 'text-rose-700', 'title' => 'text-rose-900', 'body' => 'text-rose-800'],
        'warning' => ['wrap' => 'border-amber-200 bg-amber-50', 'icon' => 'text-amber-700', 'title' => 'text-amber-900', 'body' => 'text-amber-800'],
        'info' => ['wrap' => 'border-sky-200 bg-sky-50', 'icon' => 'text-sky-700', 'title' => 'text-sky-900', 'body' => 'text-sky-800'],
        'neutral' => ['wrap' => 'border-slate-200 bg-slate-50', 'icon' => 'text-slate-600', 'title' => 'text-slate-900', 'body' => 'text-slate-700'],
    ];

    $t = $tones[$tone] ?? $tones['info'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-start gap-3 rounded-xl border p-4 ' . $t['wrap']]) }}
     role="status">
    <x-icon :name="$icon" :class="'mt-0.5 h-5 w-5 shrink-0 ' . $t['icon']" />
    <div class="min-w-0 text-sm">
        <p class="font-semibold {{ $t['title'] }}">{{ $title }}</p>
        @if($body)
            <div class="mt-1 leading-relaxed {{ $t['body'] }}">{{ $body }}</div>
        @endif
        @if(isset($slot) && trim($slot))
            <div class="mt-2.5 flex flex-wrap items-center gap-2">{{ $slot }}</div>
        @endif
    </div>
</div>
