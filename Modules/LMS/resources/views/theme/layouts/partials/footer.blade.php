@php
    $footer = $data['footer'] ?? [];
    $wrapper_class = $footer['wrapper_class'] ?? 'bg-heading mt-16 sm:mt-24 lg:mt-[120px]';
    $wrapper_style = $footer['wrapper_style'] ?? '';
    $theme = $footer['theme'] ?? 'default';
@endphp

<footer class="{{ $wrapper_class }}" style="{{ $wrapper_style }}">
    <!-- START TOP -->
    <x-dynamic-component component='{{ "{$theme}:theme::footer.content" }}' :theme="$theme" :content="$footer" :data="$data" />
    <x-dynamic-component component='{{ "{$theme}:theme::footer.bottom" }}' :theme="$theme" :content="$footer" :data="$data" />
</footer>
