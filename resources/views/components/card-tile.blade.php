@props([
    'to',
    'label' => null,
    'number' => null,
    'status' => 'active',
    'network' => null,
    'frozen' => false,
    'balanceLabel' => null,
    'balance' => null,
])

<span {{ $attributes->merge(['class' => 'relative block overflow-hidden rounded-xl p-4 text-white shadow-sm']) }}
      style="background-image: linear-gradient(135deg, #1F3A5F 0%, #24486E 45%, #2E6B5E 100%);">
    <span class="absolute -right-8 -top-10 h-32 w-32 rounded-full bg-white/10" aria-hidden="true"></span>
    <span class="absolute -bottom-12 -left-6 h-28 w-28 rounded-full bg-white/5" aria-hidden="true"></span>

    <span class="relative flex items-start justify-between gap-3">
        <span class="min-w-0">
            <span class="block text-[10px] font-semibold uppercase tracking-[0.14em] text-white/60">{{ $label }}</span>
            <span class="mt-0.5 block truncate text-sm font-semibold">{{ $number }}</span>
            @if($balanceLabel || $balance !== null)
                <span class="mt-3 block">
                    <span class="block text-[10px] font-semibold uppercase tracking-[0.14em] text-white/60">{{ $balanceLabel }}</span>
                    <span class="mt-0.5 block text-lg font-semibold tabular-nums">
                        <x-money :amount="$balance" :show-sign="false" />
                    </span>
                </span>
            @endif
        </span>

        <span class="flex shrink-0 flex-col items-end gap-1.5">
            <span class="text-[10px] font-semibold uppercase tracking-[0.14em] text-white/60">{{ $network }}</span>
            <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide
                         {{ $frozen ? 'bg-white/20 text-white' : 'bg-emerald-400/25 text-emerald-50' }}">
                @if($frozen)
                    <x-icon name="lock" class="h-3 w-3" />
                    Frozen
                @else
                    <x-icon name="check" class="h-3 w-3" />
                    Active
                @endif
            </span>
        </span>
    </span>
</span>
