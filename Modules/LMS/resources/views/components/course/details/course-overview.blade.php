@php
    if (! $course) {
        return;
    }

    $translations = $translations ?? [];
@endphp
<article>
    <h2 class="area-title xl:text-3xl mb-5">
        {{ translate('Course Overview') }}
    </h2>
    <div>
        {!! clean($translations['description'] ?? $course->description ?? '') !!}
    </div>
</article>




