@php
    $user = $instructor?->userable ?? null;
    $profile_img = $user?->profile_img ?? null;
    $thumbnail =
        $profile_img && fileExists('lms/instructors', $profile_img) == true
            ? asset('storage/lms/instructors/' . $profile_img)
            : asset('lms/frontend/assets/images/370x396.svg');

    $userTranslations = parse_translation($user);

    if ($user?->designation) {
        $designationTranslate = parse_translation($user?->designation);
    }
@endphp

<div class="col-span-full xl:col-span-6">
    <div
        class="flex flex-col sm:flex-row items-center gap-7 p-7 h-full border border-heading/15 rounded-lg hover:border-transparent hover:shadow-lg custom-transition">
        <div class="aspect-[1/1.17] max-w-60 rounded-xl overflow-hidden shrink-0">
            <a href="{{ route('users.detail', $instructor->id) }}" aria-label="Instructor profile image">
                <img data-src="{{ $thumbnail }}" alt="Instructor profile image" class="size-full object-cover">
            </a>
        </div>
        <div class="grow">
            <div class="area-description line-clamp-4">
                {!! $userTranslations['about'] ?? ($instructor?->userable?->about ?? '') !!}
            </div>
            <h6 class="text-primary text-xl font-bold mt-6">
                <a href="{{ route('users.detail', $instructor->id) }}" aria-label="Instructor full name">
                    {{ $userTranslations['first_name'] ?? $instructor->userable?->first_name }}
                    {{ $userTranslations['last_name'] ?? $instructor->userable?->last_name }}
                </a>
            </h6>
            <div class="text-heading/70">
                {{ $designationTranslate['title'] ?? ($instructor?->userable?->designation?->title ?? '') }}
            </div>
            <x-theme::social.social-list-three :socials="$instructor->socials" ulClass="flex items-center gap-2.5 mt-5" itemClass=""
                listClass="" />
        </div>
    </div>
</div>
