@php
    $userInfo = $user?->userable ?? null;
    $translations = $translations ?? [];
    $designationTranslations = $designationTranslations ?? [];
    if (empty($translations) && $userInfo) {
        $translations = parse_translation($userInfo);
    }

    if($userInfo && empty($designationTranslations) && method_exists($userInfo, 'designation')) {
        $designationTranslations = parse_translation($userInfo->designation);
    }

    $name = $translations['name'] ?? $userInfo->name ?? '';
    $firstName = $translations['first_name'] ?? $userInfo->first_name ?? '';
    $lastName = $translations['last_name'] ?? $userInfo->last_name ?? '';

    $name = isset($userInfo?->first_name, $userInfo?->last_name)
        ? "{$firstName} {$lastName}"
        : $name;

    // Define the base paths
    $imagePath = userImagePath($guard ?? null);

    $storagePath = 'lms/' . $imagePath;
    $defaultCoverImage = 'lms/frontend/assets/images/870x260.svg';
    $defaultProfileImage = 'lms/assets/images/placeholder/profile.jpg';

    // Determine the profile image
    $coverImg =
        $userInfo?->cover_photo && fileExists($storagePath, $userInfo->cover_photo)
            ? 'storage/' . $storagePath . '/' . $userInfo->cover_photo
            : $defaultCoverImage;

    $profileImg =
        $userInfo?->profile_img && fileExists($storagePath, $userInfo->profile_img)
            ? 'storage/' . $storagePath . '/' . $userInfo->profile_img
            : $defaultProfileImage;

    $designation = $userInfo?->designation ?? null;
@endphp

<div class="card p-0 bg-white dark:bg-dark-card rounded-15 overflow-hidden dk-theme-card-square">
    <div class="relative w-full h-[150px]">


        <img src="{{ asset($coverImg) }}" alt="cover-image" class="size-full object-cover">

        <label style="background:url({{ asset($profileImg) }}); background-repeat:no-repeat ;background-size:cover"
            class="file-container bg-primary-500 bg-no-repeat bg-cover bg-center absolute left-1/2 -translate-x-1/2 -bottom-[calc(theme('spacing.ins-pro-img')_/_2)] w-[calc(theme('spacing.ins-pro-img')_+_5px)] h-[theme('spacing.ins-pro-img')] border-2 border-white dark:border-dark-border-two rounded-20 dk-theme-card-square">
        </label>
    </div>

    <div class="mt-10 px-6 text-center">
        <div class="py-5">
            <div class="flex-center">
                <h4 class="text-[22px] leading-none text-heading dark:text-white font-semibold relative">
                    {{ $name }}
                    <img src="{{ asset('lms/assets/images/icons/verified-icon-green.svg') }}" alt="verified-icon"
                        class="absolute -top-1.5 -right-3.5 hidden [&.verified]:block {{ $user->is_verify == 1 ? 'verified' : '' }}"
                        title="{{ translate('Email Verified') }}">
                </h4>
            </div>
            <p class="font-spline_sans leading-[1.62] text-heading dark:!text-dark-text mt-2.5">
                {{ $shortBio ?? '' }}
            </p>


            @if ($designation)
                <p class="font-spline_sans text-sm leading-[1.62] text-gray-500 dark:text-dark-text mt-1">
                    {{ $designationTranslations['title'] ?? $userInfo?->designation?->title ?? '' }}</p>
            @endif

        </div>
        <div class="py-5 border-t border-gray-200 dark:border-dark-border text-left">
            <div class="flex-center-between">
                <h6 class="text-gray-500 dark:text-dark-text leading-none font-semibold">
                    {{ translate('About') }}
                </h6>
            </div>
            <ul
                class="flex flex-col gap-y-3 text-sm *:flex *:gap-x-2.5 *:leading-none *:text-gray-500 dark:text-dark-text dark:*:text-dark-text *:font-medium mt-4">
                <li class="items-center">
                    <div class="flex items-center gap-1">
                        <i class="ri-home-2-line text-inherit"></i>
                        {{ translate('Lives in') }}:
                    </div>
                    <span class="text-heading dark:!text-dark-text">{{ $userInfo->location ?? '' }}</span>
                </li>
            </ul>
        </div>
        <div class="py-5 border-t border-gray-200 dark:border-dark-border text-left">
            <div class="flex-center-between">
                <h6 class="text-gray-500 dark:text-dark-text leading-none font-semibold">
                    {{ translate('Basic Info') }}
                </h6>
            </div>
            <ul
                class="flex flex-col gap-y-3 text-sm *:flex *:items-center *:gap-x-2.5 *:leading-none *:text-gray-500 dark:text-dark-text dark:*:text-dark-text *:font-medium mt-4">
                <li class="items-center">
                    <div class="flex items-center gap-1">
                        <i class="ri-mail-line text-inherit"></i>
                        {{ translate('Email') }}:
                    </div>
                    <span class="text-heading dark:!text-dark-text">{{ $user->email ?? '' }}</span>
                </li>
                @if ($userInfo->phone)
                    <li>
                        <a href="#" class="hover:text-heading dark:hover:text-dark-text-two"></a>
                    </li>
                    <li class="items-center">
                        <div class="flex items-center gap-1">
                            <i class="ri-phone-line text-inherit"></i>
                            {{ translate('Phone') }}:
                        </div>
                        <span class="text-heading dark:!text-dark-text">{{ $userInfo->phone ?? '' }}</span>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
