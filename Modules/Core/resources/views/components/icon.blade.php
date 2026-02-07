@props(['name', 'style' => 'duotone', 'size' => null])

@php
    $iconClass = config('icons.' . $name);

    if ($iconClass) {
        if ($style !== 'duotone') {
            // Replace fa-duotone with fa-{style}
            $iconClass = str_replace('fa-duotone', 'fa-' . $style, $iconClass);
        }

        if ($size) {
            $iconClass .= ' fa-' . $size;
        }
    }
@endphp

@if($iconClass)
    <i {{ $attributes->merge(['class' => $iconClass]) }}></i>
@else
    <span {{ $attributes }}></span>
@endif
