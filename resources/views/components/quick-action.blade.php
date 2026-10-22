@props([
    'label',
    'href',
    'icon',
    'description' => null,
])

<a href="{{ $href }}"
   class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-left shadow-sm transition-colors hover:border-brand-300 hover:bg-brand-50/40 focus-ring">
    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-700 ring-1 ring-brand-100 transition-colors group-hover:bg-white">
        <x-icon :name="$icon" class="h-[18px] w-[18px]" />
    </span>
    <span class="min-w-0">
        <span class="block text-sm font-semibold text-slate-900">{{ $label }}</span>
        @if($description)
            <span class="mt-0.5 block truncate text-xs text-slate-500">{{ $description }}</span>
        @endif
    </span>
</a>
