@props([
    'title' => null,
    'description' => null,
    'href' => null,
    'linkLabel' => null,
])

<section {{ $attributes->merge(['class' => 'flex flex-col rounded-xl border border-slate-200 bg-white shadow-sm']) }}>
    @if($title || isset($header))
        <header class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-200 px-5 py-4">
            <div class="min-w-0">
                <h2 class="text-sm font-semibold tracking-tight text-slate-900">{{ $title }}</h2>
                @if($description)
                    <p class="mt-0.5 text-xs text-slate-500">{{ $description }}</p>
                @endif
            </div>

            @if(isset($header) && trim($header))
                <div class="flex shrink-0 items-center gap-2">{{ $header }}</div>
            @elseif($href && $linkLabel)
                <a href="{{ $href }}"
                   class="inline-flex items-center gap-1 rounded-md text-xs font-semibold text-brand-700 transition-colors hover:text-brand-900 focus-ring">
                    {{ $linkLabel }}
                    <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                </a>
            @endif
        </header>
    @endif

    @if(isset($slot) && trim($slot))
        <div class="min-h-0 flex-1">{{ $slot }}</div>
    @endif
</section>
