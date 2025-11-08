@php
    $user = $organization?->userable ?? null;
    $profile_img = $user?->profile_img ?? '';
    $bgImage =
        $user->cover_photo && fileExists('lms/organizations', $user->cover_photo) == true
            ? asset("storage/lms/organizations/{$user->cover_photo}")
            : asset('lms/frontend/assets/images/870x260.svg');

    $imgSrc =
        $profile_img && fileExists('lms/organizations', $profile_img) == true
            ? asset("storage/lms/organizations/{$profile_img}")
            : asset('lms/frontend/assets/images/870x260.svg');

    $totalCourse = $organization?->organizationCourses->count();
    $totalInstructor = $organization?->organizationInstructors->count();

    $coursesId = $totalCourse ? $organization?->organizationCourses->pluck('id')->toArray() : null;
    $rating = instructorOrgUser_review($coursesId);
    $city = $user?->city?->name ?? '';

    $userTranslations = parse_translation($user);

    if ($userTranslations) {
        $name = $userTranslations['name'];
    }
    $city = $user?->city?->name ?? '';
    if ($user?->city) {
        $cityTranslations = parse_translation($user?->city);
    }
    if ($user?->country) {
        $countryTranslations = parse_translation($user?->country);
    }

    $cityName =
        isset($cityTranslations['name']) && $cityTranslations['name']
            ? $cityTranslations['name'] . ','
            : ($city
                ? $city . ','
                : '');
@endphp


<!-- ORGANIZATION CARD -->
<div class="swiper-slide">
    <div class="relative flex flex-col bg-white h-full border border-border rounded-2xl overflow-hidden hover:shadow-md custom-transition">
        <div class="w-full h-28 bg-no-repeat bg-cover bg-center shrink-0" style="background-image: url('{{ $bgImage }}');"></div>
        <div class="flex-center !justify-start flex-col px-6 pb-10 w-full -mt-10 gap-2 grow">
            <div class="relative">
                <div class="size-[70px] rounded-50 overflow-hidden border-2 border-white">
                    <img data-src="{{ $imgSrc }}" class="size-full object-cover" alt="Organization profile image">
                </div>
                <!-- VERIFIED ICON -->
                @if ($organization->is_verify)
                    <img data-src="{{ asset('lms/frontend/assets/images/icons/verified.svg') }}" alt="Verified Icon"
                        class="size-4 absolute bottom-1 right-1" title="Verified">
                @endif
            </div>
            <div class="flex-center mt-2">
                <h5 class="text-center area-title text-2xl font-semibold hover:text-primary line-clamp-2">
                    <a href="{{ route('users.detail', $organization->id) }}" aria-label="Organization name">
                        {{ $name ?? ($user->name ?? '') }}
                        <span class="absolute inset-0" aria-hidden="true"></span>
                    </a>
                </h5>
            </div>
            <p class="text-center area-description line-clamp-2 -mt-1">
                {{ $cityName }} {{ $countryTranslations['name'] ?? $user?->country?->name }}
            </p>
            <ul
                class="flex-center divide-x rtl:divide-x-reverse divide-border space-x-5 rtl:space-x-reverse [&>:not(:first-child)]:pl-5 rtl:[&>:not(:first-child)]:pl-0 rtl:[&>:not(:first-child)]:pr-5 leading-none text-heading/70 mt-5">
                <li class="flex flex-col gap-2 text-center">
                    <h6 class="area-title text-lg font-semibold !leading-none">
                        {{ $rating['total'] }}
                    </h6>
                    <div class="flex items-center gap-0.5 text-secondary">
                        {!! show_rating($rating['average_rating']) !!}
                    </div>
                </li>
                <li class="flex flex-col gap-2 text-center">
                    <h6 class="area-title text-lg font-semibold !leading-none">
                        {{ $totalInstructor / 1000 }} {{ translate('K') }} +
                    </h6>
                    <p class="area-description text-sm font-semibold !leading-none">
                        {{ translate('Total Instructors') }}
                    </p>
                </li>
            </ul>
        </div>
    </div>
</div>
