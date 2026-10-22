@props([
    'label',
    'value' => null,
    'hint' => null,
    'icon' => null,
    'href' => null,
    'tone' => 'default',
    'blank' => false,
])

@php
    $tones = [
        'default' => 'text-slate-900',
        'success' => 'text-emerald-700',
        'brand' => 'text-brand-800',
        'muted' => 'text-slate-500',
    ];

    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }} @if($href) href="{{ $href }}" @endif
    @if($href) class="group block rounded-xl border border-slate-200 bg-white p-4 text-left shadow-sm transition-colors hover:border-brand-300 hover:bg-brand-50/30 focus-ring" @else class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm" @endif>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="truncate text-xs font-medium uppercase tracking-wide text-slate-500">{{ $label }}</p>

            @if($value !== null || $blank)
                <p class="mt-1.5 text-xl font-semibold tracking-tight tabular-nums {{ $tones[$tone] ?? $tones['default'] }}">
                    @if($blank)
                        <span data-balance-blank>••••••</span>
                    @else
                        {{ $value }}
                    @endif
                </p>
            @endif

            @if($hint)
                <p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>
            @endif
        </div>

        @if($icon)
            <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-50 text-slate-500 ring-1 ring-slate-200 {{ $href ? 'group-hover:bg-white' : '' }}">
                <x-icon :name="$icon" class="h-[18px] w-[18px]" />
            </span>
        @endif
    </div>
</{{ $tag }}>
