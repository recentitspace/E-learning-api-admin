@php
    $pageTranslations = parse_translation($page);
@endphp
<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="{{ $title }}" pageName="{{ $title }}" />
    <div class="container">
        {!! clean($pageTranslations['content'] ?? ($page->content ?? '')) !!}
    </div>
</x-frontend-layout>
