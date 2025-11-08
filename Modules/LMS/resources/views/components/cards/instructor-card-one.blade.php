@php
    $user = $instructor?->userable ?? null;
    $profileImg = $user?->profile_img ?? '';
    $imgSrc =
        $profileImg && fileExists('lms/instructors', $profileImg) == true
            ? asset('storage/lms/instructors/' . $profileImg)
            : asset('lms/frontend/assets/images/370x396.svg');
    $userTranslations = parse_translation($user);
    if ($user?->designation) {
        $designationData = parse_translation($user?->designation);
    }
    if ($userTranslations) {
        $name = $userTranslations['first_name'] . ' ' . $userTranslations['last_name'];
    }

@endphp

<div class="swiper-slide col-span-full sm:col-span-6 xl:col-span-4">
    <div class="relative flex flex-col group/instructor">
        <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
            <img data-src="{{ $imgSrc }}" alt="Thumbnail image"
                class="size-full object-cover group-hover/instructor:scale-110 custom-transition">
            @if ($instructor->socials->count() > 0)
                <x-theme::social.social-list-one
                    :socials="$instructor->socials" hoverButton="yes"
                    ulClass=""
                    itemClass="flex-center size-10 rounded-50 bg-primary text-white hover:bg-secondary hover:text-heading dark:text-white custom-transition"
                    listClass="absolute top-3 right-2.5 z-0 group-hover/instructor:top-[calc(40px_*_1_+_12px)] duration-500"
                />
            @endif
        </div>
        <div class="flex justify-between mt-6">
            <div class="shrink-0 grow">
                <h6 class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                    <a href="{{ route('users.detail', $instructor->id) }}" class="flex items-center justify-between"
                        aria-label="Instructor full name">
                        {{ $name ?? $user?->first_name . ' ' . $user?->last_name }}
                        <i class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                        <span class="absolute inset-0" aria-hidden="true"></span>
                    </a>
                </h6>
                <p class="area-description !leading-none mt-1.5">
                    {{ $designationData['title'] ?? ($user?->designation?->title ?? '') }}
                </p>
            </div>
        </div>
    </div>
</div>
