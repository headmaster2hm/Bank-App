@props([
    'amount' => null,
    'sign' => 'auto',
    'class' => '',
    'blank' => '••••••',
    'showSign' => true,
])

@php
    $value = $amount === null ? null : (float) $amount;
    $formatted = $value === null
        ? null
        : '$' . number_format(abs($value), 2);

    $prefix = '';

    if ($value !== null) {
        $direction = match ($sign) {
            'positive' => 'up',
            'negative' => 'down',
            default => $value >= 0 ? 'up' : 'down',
        };

        if ($showSign && $value != 0) {
            $prefix = $direction === 'up' ? '+' : '−';
        }
    }
@endphp

<span
    @if($value === null) data-balance-blank @endif
    class="tabular-nums {{ $class }}"
>{{ $value === null ? $blank : $prefix . $formatted }}</span>
