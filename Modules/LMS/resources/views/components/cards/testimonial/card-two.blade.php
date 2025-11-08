@php
    $profileImagePath = 'storage/lms/testimonials/' . $testimonial->profile_image;
    $defaultProfileImage =  'lms/frontend/assets/images/370x396.svg';
    $profileImageSrc = fileExists('lms/testimonials', $testimonial->profile_image) && $testimonial->profile_image != ''
        ? asset($profileImagePath)
        : asset($defaultProfileImage);
    $translations = parse_translation($testimonial);
@endphp

 <div class="swiper-slide swiper-slide-active">
    <div class="bg-[#E6ECFB] p-[30px_25px] xl:p-[60px_50px] h-full grow">
    <div class="flex items-center gap-0.5 text-secondary">
        {!! show_rating($translations['rating'] ?? $testimonial->rating ?? 0) !!}
    </div>
    <div class="area-description text-heading mt-5">
        {!! clean($translations['comments'] ?? $testimonial->comments ?? '') !!}
    </div>
    <div class="flex items-center gap-2.5 mt-10">
        <div class="size-11 rounded-50 overflow-hidden shrink-0">
            <img data-src="{{ $profileImageSrc }}" alt="Testimonial profile" class="size-full object-cover">
        </div>
        <div class="grow">
        <h6 class="area-title text-lg !leading-none">
            {{ $translations['name'] ?? $testimonial->name ?? '' }}
        </h6>
        <p class="area-description !leading-none mt-1.5">
            {{ $translations['designation'] ?? $testimonial->designation ?? ''}}
        </p>
        </div>
    </div>
    </div>
</div>