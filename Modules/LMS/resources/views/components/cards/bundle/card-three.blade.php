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

<div class="flex flex-col bg-white h-full rounded-xl custom-transition overflow-hidden group/course">
    <!-- COURSE THUMBNAIL -->
    <div class="relative aspect-[1.64] overflow-hidden shrink-0">
        <img data-src="{{ $thumbnail }}" alt="Course Thumbnail"
            class="size-full object-cover group-hover/course:scale-110 custom-transition" />
    </div>
    <!-- COURSE CONTENT -->
    <div class="px-5 py-6 border border-border border-t-0 rounded-b-xl grow">
        <div class="flex-center-between gap-2">
            @if (isset($bundle?->category?->title))
                <div class="badge badge-primary-light rounded-none">
                    {{ $categoryTranslations['title'] ?? $bundle?->category?->title }}
                </div>
            @endif
            <div class="text-heading text-xl !leading-none font-bold text-right shrink-0 flex items-center gap-1.5">
                {{ $currencySymbol }}{{ dotZeroRemove($bundle?->price ?? 0) }}
            </div>
        </div>
        <h6 class="area-title font-bold !text-xl mt-3 group-hover/course:text-primary custom-transition">
            <a href="{{ route('bundle.detail', $bundle->slug) }}" aria-label="Course details link" class="line-clamp-2">
                {{ $translations['title'] ?? ($bundle->title ?? '') }}
            </a>
        </h6>
    </div>
</div>
