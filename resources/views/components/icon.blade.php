@props([
    'name',
    'class' => 'h-5 w-5',
    'title' => null,
])

<svg {{ $attributes->merge(['class' => $class]) }} role="{{ $title ? 'img' : 'presentation' }}"
     {{ $title ? 'aria-label="' . $title . '"' : 'aria-hidden="true"' }} focusable="false">
    @if($title)
        <title>{{ $title }}</title>
    @endif
    <use href="#i-{{ $name }}"></use>
</svg>
