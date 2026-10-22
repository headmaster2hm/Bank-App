@props([
    'title' => null,
    'description' => null,
    'icon' => 'info',
    'actionLabel' => null,
    'actionHref' => null,
    'compact' => false,
])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-slate-200 bg-slate-50/70 ' . ($compact ? 'p-5' : 'px-5 py-10')]) }}>
    <div class="flex flex-col items-center text-center">
        <span class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-full bg-white text-slate-500 ring-1 ring-slate-200">
            <x-icon :name="$icon" />
        </span>

        @if($title)
            <p class="text-sm font-semibold text-slate-900">{{ $title }}</p>
        @endif

        @if($description)
            <p class="mt-1.5 max-w-sm text-sm leading-relaxed text-slate-600">{{ $description }}</p>
        @endif

        @if(isset($slot) && trim($slot))
            <div class="mt-4 text-sm text-slate-600">{{ $slot }}</div>
        @endif

        @if($actionLabel && $actionHref)
            <a href="{{ $actionHref }}"
               class="mt-5 inline-flex items-center gap-1.5 rounded-lg bg-brand-700 px-3.5 py-2 text-sm font-semibold text-white transition-colors hover:bg-brand-800 focus-ring">
                {{ $actionLabel }}
                <x-icon name="chevron-right" class="h-4 w-4" />
            </a>
        @endif
    </div>
</div>
