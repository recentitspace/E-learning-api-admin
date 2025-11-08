@php
$translations = parse_translation($category);
@endphp

<!-- CATEGORY CARD -->
<div class="col-span-full sm:col-span-6 lg:col-span-3">
    <div class="bg-white/5 px-4 py-7 rounded-xl flex-center flex-col gap-1 border border-transparent hover:border-secondary custom-transition h-full group/category">
        <h6 class="area-title text-base xl:text-xl font-bold text-white text-center" >
            {{ $translations['title'] ?? $category->title ?? '' }}
        </h6>
        <p class="area-description text-white/70">
            {{$category->courses_count ?? 0}}+ {{ translate('Course Available') }}
        </p>
    </div>
</div>
