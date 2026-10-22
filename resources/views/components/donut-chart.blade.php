@props([
    'slices' => [],
    'total' => 0,
    'centerLabel' => null,
    'size' => 168,
])

@php
    $radius = 70;
    $stroke = 22;
    $circumference = 2 * M_PI * $radius;
    $offset = 0.0;

    $slices = collect($slices)->filter(fn ($slice) => ($slice['total'] ?? 0) > 0)->values();
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col items-center']) }}>
    <div class="relative shrink-0" style="width: {{ $size }}px; height: {{ $size }}px;">
        <svg viewBox="0 0 200 200" width="{{ $size }}" height="{{ $size }}" role="img"
             aria-label="{{ $centerLabel ? $centerLabel . ': ' . $slices->pluck('label')->implode(', ') : 'Spending breakdown by category' }}">
            <title>{{ $centerLabel ? $centerLabel . ' spending by category' : 'Spending by category' }}</title>
            <circle cx="100" cy="100" r="{{ $radius }}" fill="none" stroke="#E2E8F0" stroke-width="{{ $stroke }}" />
            <g transform="rotate(-90 100 100)">
                @foreach($slices as $slice)
                    @php
                        $share = $total > 0 ? $slice['total'] / $total : 0;
                        $length = $share * $circumference;
                    @endphp
                    <circle cx="100" cy="100" r="{{ $radius }}" fill="none"
                            stroke="{{ $slice['color'] }}"
                            stroke-width="{{ $stroke }}"
                            stroke-dasharray="{{ round($length, 2) }} {{ round(max(0, $circumference - $length), 2) }}"
                            stroke-dashoffset="{{ round(-$offset, 2) }}"
                            data-category="{{ $slice['label'] }}"
                            data-amount="{{ number_format((float) $slice['total'], 2) }}"
                            data-percentage="{{ number_format($share * 100, 1) }}">
                        <title>{{ $slice['label'] }}: ${{ number_format((float) $slice['total'], 2) }} ({{ number_format($share * 100, 1) }}%)</title>
                    </circle>
                    @php $offset += $length; @endphp
                @endforeach
            </g>
        </svg>

        @if($centerLabel)
            <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center text-center">
                <span class="text-[11px] font-medium uppercase tracking-wide text-slate-500">{{ $centerLabel }}</span>
                <span class="mt-0.5 text-lg font-semibold tracking-tight text-slate-900 tabular-nums" data-balance-sensitive>
                    $<x-money :amount="$total" :show-sign="false" />
                </span>
            </div>
        @endif
    </div>
</div>
