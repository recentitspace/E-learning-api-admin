@php
    $profileImagePath = 'storage/lms/testimonials/' . $testimonial->profile_image;
    $defaultImage = 'lms/frontend/assets/images/placeholder/profile.jpg';
    $imageSrc = fileExists('lms/testimonials', $testimonial->profile_image) && $testimonial->profile_image != ''
        ? asset($profileImagePath)
        : asset($defaultImage);
    $translations = parse_translation($testimonial);
@endphp

<div class="swiperx-slide">
    <div
      class="bg-white/5 rounded-[20px] backdrop-blur-sm p-[30px_25px] md:p-[60px_50px] h-full relative"
    >
      <span class="absolute -top-3">
        <img
          data-src="{{ asset('lms/frontend/assets/images/icons/quote-yellow.svg') }}"
          alt="Quote icon yellow"
          class="shrink-0 animate-bounce"
        />
      </span>
      <div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7">
        <div class="col-span-full md:col-span-7 order-2 md:order-1">
          <div class="flex items-center gap-0.5 text-secondary">
            {!! show_rating($translations['rating'] ?? $testimonial->rating ?? 0) !!}
          </div>
          <div
            class="area-description lg:text-lg xl:text-2xl text-white mt-2 xl:mt-7 md:line-clamp-4 xl:line-clamp-5"
          >
          {!! clean($translations['comments'] ?? $testimonial->comments ?? '') !!}
          </div>
          <div class="flex justify-between mt-10">
            <div class="shrink-0 grow">
              <h6
                class="area-title text-lg text-white !leading-none"
              >
                {{ $translations['name'] ?? $testimonial->name ?? '' }}
              </h6>
              <p
                class="area-description !leading-none text-white/70 mt-1.5"
              >
                {{ $translations['designation'] ?? $testimonial->designation ?? ''}}
              </p>
            </div>
          </div>
        </div>
        <div
          class="col-span-full md:col-span-5 order-1 md:order-2 h-full relative"
        >
          <div class="md:absolute md:bottom-0 md:right-0 w-full bg-[#033028] rounded-t-full overflow-hidden aspect-[1/1.05] max-w-[470px] flex-center !items-end">
            <img data-src="{{ $imageSrc }}" alt="Testimonial profile" class="size-full object-cover">
          </div>
        </div>
      </div>
    </div>
  </div>