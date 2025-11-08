@php
$translations = parse_translation($category);
@endphp

<!-- CATEGORY CARD -->
<div class="col-span-full sm:col-span-6 lg:col-span-3">
    <div class="bg-primary-50 category-bg-color px-4 py-7 flex-center custom-transition group/category h-full">
        <h6 class="area-title text-base xl:text-xl font-bold text-center">
            {{ $translations['title'] ?? $category->title ?? ''}}
        </h6>
    </div>
</div>
<!-- CATEGORY CARD -->