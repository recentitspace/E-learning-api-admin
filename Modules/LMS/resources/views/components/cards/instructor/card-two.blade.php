@php
    if (!$instructor) {
        return;
    }

    $user = $instructor?->userable ?? null;
    $profile_img = $user?->profile_img ?? null;
    $thumbnail =
        $profile_img && fileExists('lms/instructors', $profile_img) == true
            ? asset("storage/lms/instructors/{$profile_img}")
            : asset('lms/frontend/assets/images/370x396.svg');

    $userTranslations = parse_translation($user);

    if ($user?->designation) {
        $designationTranslate = parse_translation($user?->designation);
    }

    if ($userTranslations) {
        $name = $userTranslations['first_name'] . ' ' . $userTranslations['last_name'];
    }
@endphp

<div class="swiper-slide lg:odd:mb-7 lg:even:mt-7 swiper-slide-prev">
    <div class="relative flex-center aspect-[1/1.33] overflow-hidden custom-transition group/instructor before:absolute before:size-full before:inset-0 before:bg-overlay-gradient before:opacity-0 hover:before:opacity-100 before:custom-transition">
        <!-- THUMBNAIL -->
        <img data-src="{{ $thumbnail }}" alt="Instructor image"
            class="size-full object-cover group-hover/course:scale-110 custom-transition">
        <!-- CONTENT -->
        <div class="absolute right-0 bottom-0 left-0 p-7 pt-10 bg-overlay-gradient overflow-hidden shrink-0 custom-transition">
            <h5 class="area-title text-xl text-white font-bold !leading-[1.44] line-clamp-1">
                <a href="{{ route('users.detail', $instructor->id) }}" aria-label="Instructor information">
                    {{ $name ?? $user?->first_name . ' ' . $user?->last_name }}
                    <span class="absolute inset-0" aria-hidden="true"></span>
                </a>
            </h5>
            <p class="area-description text-sm font-medium uppercase text-white/70">
                {{ $designationTranslate['title'] ?? ($user?->designation?->title ?? '') }}
            </p>
        </div>
        @if ($instructor->socials->count() > 0)
            <x-theme::social.social-list-two :socials="$instructor->socials" hoverButton="yes"
                ulClass="absolute top-3 right-2.5 z-10 flex flex-col gap-1 invisible opacity-0 group-hover/instructor:opacity-100 group-hover/instructor:visible custom-transition"
                itemClass="flex-center size-10 rounded-50 bg-primary text-white hover:bg-secondary hover:text-heading custom-transition"
                listClass="translate-x-[calc(10px_*_1)] group-hover/instructor:translate-x-0 delay-[calc(100ms_*_1)] custom-transition" />
        @endif
    </div>
</div>
