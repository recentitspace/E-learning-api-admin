@php
    $translations = parse_translation($bundle);

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

<div class="relative flex-center aspect-[1/1.16] overflow-hidden custom-transition group/course">
    <!-- PRICE -->
    <span
        class="badge b-solid badge-primary-solid font-bold rounded-none absolute top-4 left-4 rtl:left-auto rtl:right-4 z-10">
        {{ $currencySymbol }}{{ dotZeroRemove($bundle?->price ?? 0) }}
    </span>
    <!-- THUMBNAIL -->
    <img data-src="{{ $thumbnail }}" alt="Course thumbnail"
        class="size-full object-cover object-left group-hover/course:scale-110 custom-transition">
    <!-- CONTENT -->
    <div
        class="absolute right-0 bottom-0 left-0 p-7 pt-10 bg-overlay-gradient group-hover/course:bg-heading overflow-hidden shrink-0 custom-transition">
        <h5 class="area-title text-lg text-white font-bold !leading-[1.44] text-center line-clamp-2">
            <a href="{{ route('bundle.detail', $bundle->slug) }}" aria-label="Course details link">
                {{ $translations['title'] ?? ($bundle->title ?? '') }}
            </a>
        </h5>
    </div>
</div>
