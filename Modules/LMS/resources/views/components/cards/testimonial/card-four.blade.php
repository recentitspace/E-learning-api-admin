@php
    if (!$testimonial || !is_object($testimonial)) {
        return;
    }

    $profileImagePath = 'storage/lms/testimonials/' . $testimonial->profile_image;
    $defaultImage = 'lms/frontend/assets/images/placeholder/profile.jpg';
    $imageSrc =
        $testimonial->profile_image && fileExists('lms/testimonials', $testimonial->profile_image)
            ? asset($profileImagePath)
            : asset($defaultImage);
    $translations = parse_translation($testimonial);
@endphp

<div class="swiper-slide">
    <div
        class="flex flex-col sm:flex-row sm:items-center gap-7 p-7 h-full bg-section rounded-2xl hover:border-transparent hover:shadow-lg custom-transition">
        <div class="aspect-[1/1.22] max-w-56 rounded-xl overflow-hidden shrink-0">
            <img data-src="{{ $imageSrc }}" alt="Testimonial profile" class="size-full object-cover">
        </div>
        <div class="grow">
            <div class="flex items-center gap-0.5 text-warning">{!! show_rating($translations['rating'] ?? $testimonial->rating ?? 0) !!}</div>
            <div class="area-description mt-5 line-clamp-4">{!! clean($translations['comments'] ?? $testimonial->comments ?? '') !!}</div>
            <div class="flex justify-between mt-10">
                <div class="shrink-0 grow">
                    <h6 class="area-title text-lg text-secondary !leading-none">{{ $translations['name'] ?? $testimonial->name ?? '' }}</h6>
                    <p class="area-description !leading-none mt-1.5">{{ $translations['designation'] ?? $testimonial->designation ?? '' }}</p>
                </div>
                <img data-src="{{ asset('lms/frontend/assets/images/icons/quote-green-outline.svg') }}"
                    alt="Quote Icon" class="shrink-0 animate-bounce">
            </div>
        </div>
    </div>
</div>
