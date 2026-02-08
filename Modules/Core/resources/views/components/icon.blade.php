@props(['name', 'style' => 'duotone', 'size' => null])

@php
    $iconClass = config('icons.' . $name);

    // Fallback: If not in config, use the name directly
    if (!$iconClass) {
        $iconClass = "fa-duotone fa-{$name}";
    }

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
    <!-- Safety fallback if name is empty -->
    <i {{ $attributes->merge(['class' => 'fa-duotone fa-circle-question text-red-500', 'title' => 'Icon name missing']) }}></i>
@endif
