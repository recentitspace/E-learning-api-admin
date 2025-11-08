@php
    if (!$bundle) {
        return;
    }
    $translations = $translations ?? [];
@endphp
<article>
    <h2 class="area-title xl:text-3xl mb-5">
        {{ translate('Bundle Overview') }}
    </h2>
    <div>
        {!! clean($translations['details'] ?? ($bundle->details ?? '')) !!}
    </div>
</article>
