@php
    if (!$instructor) {
        return;
    }

    $user = $instructor?->userable ?? null;
    $profile_img = $user?->profile_img ?? null;
    $thumbnail =
        $profile_img && fileExists('lms/instructors', $profile_img) == true
            ? asset('storage/lms/instructors/' . $profile_img)
            : asset('lms/frontend/assets/images/370x396.svg');
    $userTranslations = parse_translation($user);
    if ($userTranslations) {
        $name = $userTranslations['first_name'] . ' ' . $userTranslations['last_name'];
    }

    if ($user?->designation) {
        $designationTranslate = parse_translation($user?->designation);
    }
@endphp

<div class="swiper-slide">
    <div class="flex flex-col group/instructor">
        <div
            class="aspect-[1/1.14] overflow-hidden rounded-xl image-mask mask-kid-instructor relative before:absolute before:size-full before:inset-0 before:bg-primary/60 before:invisible before:opacity-0 group-hover/instructor:before:visible group-hover/instructor:before:opacity-100 before:custom-transition before:z-[1]">
            <img data-src="{{ $thumbnail }}" alt="Instructor Profile image"
                class="size-full object-cover group-hover/instructor:scale-110 custom-transition">
            <!-- SOCIAL -->
            @if ($instructor->socials->count() > 0)
                <x-theme::social.social-list-one :socials="$instructor->socials" hover-button="yes"
                    ul-class="flex gap-1.5 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 invisible opacity-0 group-hover/instructor:visible group-hover/instructor:opacity-100 duration-300 z-[2]"
                    list-class="[&:first-child]:-translate-x-10 [&:last-child]:translate-x-10 group-hover/instructor:translate-x-0 duration-300 delay-300"
                    item-class="flex-center size-11 rounded-50 border border-white/25 text-white hover:bg-secondary hover:text-heading hover:border-transparent custom-transition" />
            @endif
        </div>
        <div class="flex flex-col text-center mt-6">
            <h6
                class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                <a href="{{ route('users.detail', $instructor->id) }}" aria-label="Instructor profile link">
                    {{ $name ?? $user?->first_name . ' ' . $user?->last_name }}
                </a>
            </h6>
            <div class="area-description !leading-none mt-2">
                {{ $designationTranslate['title'] ?? ($user?->designation?->title ?? '') }}
            </div>
        </div>
    </div>
</div>
