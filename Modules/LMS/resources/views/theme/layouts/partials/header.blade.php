@php
    $header = $data['header'] ?? [];
    $theme = $header['theme'] ?? 'default';
@endphp
<x-dynamic-component 
    component='{{ "{$theme}:theme::header.header" }}' 
    :theme="$theme" 
    :content="$header"
    :data="$data" 
/>
<x-theme::header.mobile-menu />
