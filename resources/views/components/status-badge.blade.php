@props([
    'tone' => 'neutral',
    'label' => null,
    'dot' => false,
])

@php
    $tones = [
        'neutral' => 'bg-slate-100 text-slate-700 ring-slate-200',
        'success' => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
        'info' => 'bg-sky-50 text-sky-800 ring-sky-200',
        'warning' => 'bg-amber-50 text-amber-900 ring-amber-200',
        'danger' => 'bg-rose-50 text-rose-800 ring-rose-200',
        'brand' => 'bg-brand-50 text-brand-800 ring-brand-200',
        'accent' => 'bg-accent-50 text-accent-900 ring-accent-200',
    ];

    $dots = [
        'neutral' => 'bg-slate-400',
        'success' => 'bg-emerald-600',
        'info' => 'bg-sky-600',
        'warning' => 'bg-amber-600',
        'danger' => 'bg-rose-600',
        'brand' => 'bg-brand-600',
        'accent' => 'bg-accent-600',
    ];

    $classes = $tones[$tone] ?? $tones['neutral'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset ' . $classes]) }}>
    @if($dot)
        <span class="h-1.5 w-1.5 rounded-full {{ $dots[$tone] ?? $dots['neutral'] }}" aria-hidden="true"></span>
    @endif
    {{ $label ?? $slot }}
</span>
