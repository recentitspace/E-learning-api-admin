@php
    $translations = parse_translation($bundle);
    $categoryTranslations = parse_translation($bundle->category);

    $imagePath = 'lms/courses/bundles/thumbnails';
    $defaultThumbnail = 'lms/frontend/assets/images/420x252.svg';
    $thumbnail =
        !empty($bundle?->thumbnail) && fileExists($imagePath, $bundle->thumbnail)
            ? asset('storage/' . $imagePath . '/' . $bundle->thumbnail)
            : asset($defaultThumbnail);

    $randomKey = random_string(2);
    $currency = $bundle?->currency ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp

<div
    class="flex flex-col bg-white rounded-2xl h-full p-5 group-data-[card-layout=list]:flex-row [&.card-border]:border [&.card-border]:border-border [&.card-border]:hover:shadow-md custom-transition group/course {{ isset($borderClass) ? 'card-border' : '' }}">
    <!-- COURSE THUMBNAIL -->
    <div class="relative aspect-video rounded-xl overflow-hidden">
        <img data-src="{{ $thumbnail }}"
            class="course-grid-thumb-img w-full group-hover/topCourse:scale-110 duration-300" alt="Course thumbnail" />
        <!-- badge -->
        @foreach ($bundle->levels as $level)
            @php $levelTranslations = parse_translation($level); @endphp
            <span
                class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 left-4 rtl:left-auto rtl:right-4 z-10">
                {{ $levelTranslations['name'] ?? ($level->name ?? '') }}
            </span>
        @endforeach

    </div>
    <!-- COURSE CONTENT -->
    <div class="relative mt-6 group-data-[card-layout=list]:mt-0 group-data-[card-layout=list]:ml-6">
        <div class="flex-center-between">
            @if (isset($bundle?->category?->title))
                <div class="badge badge-heading-outline b-outline rounded-full shrink-0">
                    {{ $categoryTranslations['title'] ?? $bundle?->category?->title }}
                </div>
            @endif
            <div
                class="text-primary text-xl !leading-none font-bold text-right shrink-0 flex items-center gap-1.5 ms-auto">
                <span>{{ $currencySymbol }}{{ dotZeroRemove($bundle?->price ?? 0) }}</span>
            </div>
        </div>
        <h6 class="area-title font-bold !text-xl mt-3 group-hover/course:text-primary custom-transition">
            <a href="{{ route('bundle.detail', $bundle->slug) }}" class="line-clamp-2" aria-label="bundle title">
                {{ $translations['title'] ?? ($bundle->title ?? '') }}
            </a>
        </h6>
    </div>
</div>
