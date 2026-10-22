@props([
    'series' => [],
    'height' => 150,
])

@php
    $max = 0.0;

    foreach ($series as $point) {
        $max = max($max, (float) $point['income'], (float) $point['outflow']);
    }

    $max = $max > 0 ? $max * 1.12 : 1.0;
    $barWidth = 22;
    $groupGap = 46;
    $chartWidth = max(220, count($series) * $groupGap);
    $baseline = $height - 22;
@endphp

<div {{ $attributes->merge(['class' => 'w-full overflow-x-auto']) }}>
    <div class="min-w-full" style="width: {{ $chartWidth }}px;">
        <svg viewBox="0 0 {{ $chartWidth }} {{ $height }}" width="{{ $chartWidth }}" height="{{ $height }}"
             class="block" role="img" aria-label="Cash flow: incoming compared with outgoing money over the last {{ count($series) }} months">
            <title>Cash flow for the last {{ count($series) }} months</title>

            <line x1="0" y1="{{ $baseline }}" x2="{{ $chartWidth }}" y2="{{ $baseline }}" stroke="#E2E8F0" stroke-width="1" />

            @foreach($series as $index => $point)
                @php
                    $groupX = $index * $groupGap;
                    $centre = $groupX + $groupGap / 2;
                    $incomeH = ($point['income'] / $max) * ($baseline - 8);
                    $outflowH = ($point['outflow'] / $max) * ($baseline - 8);
                @endphp

                <rect x="{{ $centre - $barWidth - 2 }}" y="{{ $baseline - $incomeH }}"
                      width="{{ $barWidth }}" height="{{ max(1, $incomeH) }}" rx="3" fill="#2E6B5E">
                    <title>{{ $point['full_label'] }}: {{ number_format((float) $point['income'], 2) }} dollars in</title>
                </rect>

                <rect x="{{ $centre + 2 }}" y="{{ $baseline - $outflowH }}"
                      width="{{ $barWidth }}" height="{{ max(1, $outflowH) }}" rx="3" fill="#B4530A">
                    <title>{{ $point['full_label'] }}: {{ number_format((float) $point['outflow'], 2) }} dollars out</title>
                </rect>

                <text x="{{ $centre }}" y="{{ $height - 6 }}" text-anchor="middle"
                      font-size="11" font-weight="600" fill="#475569">{{ $point['label'] }}</text>
            @endforeach
        </svg>
    </div>
</div>

<div class="mt-3 flex items-center justify-center gap-5 text-xs text-slate-600">
    <span class="inline-flex items-center gap-1.5">
        <span class="h-2.5 w-2.5 rounded-sm bg-[#2E6B5E]" aria-hidden="true"></span>
        Money in
    </span>
    <span class="inline-flex items-center gap-1.5">
        <span class="h-2.5 w-2.5 rounded-sm bg-[#B4530A]" aria-hidden="true"></span>
        Money out
    </span>
</div>
