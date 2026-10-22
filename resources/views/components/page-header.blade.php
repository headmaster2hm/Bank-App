@props([
    'title' => null,
    'subtitle' => null,
    'back' => null,
    'backLabel' => 'Back',
    'actions' => null,
])

<div {{ $attributes->merge(['class' => 'mb-5 flex flex-wrap items-start justify-between gap-x-4 gap-y-3']) }}>
    <div class="min-w-0">
        @if($back)
            <a href="{{ $back }}"
               class="mb-1.5 inline-flex items-center gap-1 text-xs font-semibold text-brand-700 transition-colors hover:text-brand-900 focus-ring">
                <x-icon name="chevron-right" class="h-3.5 w-3.5 rotate-180" />
                {{ $backLabel }}
            </a>
        @endif

        <h1 class="text-xl font-semibold tracking-tight text-slate-900 sm:text-2xl">{{ $title }}</h1>

        @if($subtitle)
            <p class="mt-1 text-sm text-slate-600">{{ $subtitle }}</p>
        @endif

        @if(isset($slot) && trim($slot))
            <div class="mt-3">{{ $slot }}</div>
        @endif
    </div>

    @if($actions)
        <div class="flex shrink-0 flex-wrap items-center gap-2">{{ $actions }}</div>
    @endif
</div>
