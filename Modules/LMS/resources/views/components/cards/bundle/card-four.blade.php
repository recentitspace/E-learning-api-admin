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

<div class="flex flex-col h-full rounded-xl custom-transition overflow-hidden hover:shadow-md group/course bg-white">
    <!-- COURSE THUMBNAIL -->
    <div class="relative aspect-[1.71] overflow-hidden shrink-0">
        <img data-src="{{ $thumbnail }}" alt="Course thumbnail"
            class="size-full object-cover group-hover/course:scale-110 custom-transition">
    </div>
    <!-- COURSE CONTENT -->
    <div class="flex flex-col px-4 lg:px-5 py-6 rounded-b-xl grow">
        @if (isset($bundle?->category?->title))
            <div class="flex-center-between gap-2 flex-wrap mb-5">
                <div class="flex items-center gap-1.5 area-description !text-secondary text-sm !leading-none shrink-0">
                    <i class="ri-graduation-cap-fill"></i>
                    {{ $categoryTranslations['title'] ?? $bundle?->category?->title }}
                </div>
            </div>
        @endif
        <h6 class="area-title font-bold !text-xl group-hover/course:text-secondary mb-6 custom-transition">
            <a href="{{ route('bundle.detail', $bundle->slug) }}" class="line-clamp-2" aria-label="Course details link">
                {{ $translations['title'] ?? ($bundle->title ?? '') }}
            </a>
        </h6>
        <div class="flex-center-between gap-2 pt-4 border-t border-heading/10 mt-auto">
            <div class="text-heading text-xl !leading-none font-bold flex items-center flex-wrap gap-1.5">
                {{ $currencySymbol }}{{ dotZeroRemove($bundle?->price ?? 0) }}
            </div>
            <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                <a href="{{ route('bundle.detail', $bundle->slug) }}"
                    class="btn b-solid btn-primary-solid !text-heading font-bold capitalize" aria-label="Buy course">
                    {{ translate('Buy course') }}
                </a>
            </div>
        </div>
    </div>
</div>
