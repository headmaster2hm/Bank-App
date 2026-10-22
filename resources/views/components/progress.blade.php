@props([
    'value' => 0,
    'max' => 100,
    'tone' => 'brand',
    'label' => null,
    'size' => 'md',
])

@php
    $clamped = $max > 0 ? max(0, min(100, ($value / $max) * 100)) : 0;
    $percentLabel = $clamped . '%';

    $bars = [
        'brand' => 'bg-brand-700',
        'success' => 'bg-emerald-600',
        'accent' => 'bg-accent-600',
    ];

    $heights = [
        'sm' => 'h-1.5',
        'md' => 'h-2',
        'lg' => 'h-2.5',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    @if($label)
        <div class="mb-1.5 flex items-center justify-between gap-3">
            <span class="text-xs font-medium text-slate-600">{{ $label }}</span>
            <span class="text-xs font-semibold tabular-nums text-slate-700">{{ $percentLabel }}</span>
        </div>
    @endif

    <div class="w-full overflow-hidden rounded-full bg-slate-200 {{ $heights[$size] ?? $heights['md'] }}"
         role="progressbar" aria-valuenow="{{ round($clamped, 1) }}" aria-valuemin="0" aria-valuemax="100"
         aria-label="{{ $label ? $label . ' progress' : 'Progress' }}">
        <div class="h-full rounded-full {{ $bars[$tone] ?? $bars['brand'] }} transition-[width] duration-500"
             style="width: {{ $clamped }}%"></div>
    </div>
</div>
