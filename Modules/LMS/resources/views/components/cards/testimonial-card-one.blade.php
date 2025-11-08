@php
    $profileImagePath = 'storage/lms/testimonials/' . $testimonial->profile_image;
    $defaultProfileImage = 'lms/frontend/assets/images/370x396.svg';
    $profileImageSrc =
        fileExists('lms/testimonials', $testimonial->profile_image) && $testimonial->profile_image != ''
            ? asset($profileImagePath)
            : asset($defaultProfileImage);
    $translations = parse_translation($testimonial);
@endphp

<div class="swiper-slide">
    <div class="flex flex-col xl:flex-row rtl:xl:flex-row-reverse items-center h-full group/testimonial">
        <div
            class="flex-center size-24 rounded-50 border border-primary p-1.5 overflow-hidden shrink-0 xl:translate-x-12 translate-y-12 xl:translate-y-0">
            <img data-src="{{ $profileImageSrc }}" alt="Testimonial image"
                class="size-full rounded-50 object-cover group-hover/testimonial:scale-110 custom-transition">
        </div>
        <div class="h-full bg-primary-50 rounded-2xl p-[80px_30px_30px] xl:p-[50px_30px_50px_80px] grow">
            <div class="flex items-center gap-0.5 text-secondary">
                {!! show_rating($translations['rating'] ?? ($testimonial->rating ?? 0)) !!}
            </div>
            <div class="area-description line-clamp-3 mt-5">
                {!! clean($translations['comments'] ?? ($testimonial->comments ?? '')) !!}
            </div>
            <div class="flex justify-between mt-10">
                <div class="shrink-0 grow">
                    <h6 class="area-title text-lg !leading-none">
                        {{ $translations['name'] ?? ($testimonial->name ?? '') }}</h6>
                    <p class="area-description !leading-none mt-1.5">
                        {{ $translations['designation'] ?? ($testimonial->designation ?? '') }}
                    </p>
                </div>
                <img data-src="{{ asset('lms/frontend/assets/images/icons/quote.svg') }}" alt="Quote icon"
                    class="shrink-0 animate-bounce">
            </div>
        </div>
    </div>
</div>
