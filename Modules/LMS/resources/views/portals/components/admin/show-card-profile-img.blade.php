<div class="relative w-full h-[130px]">
    @php
        $userInfo = authCheck()?->userable ?? null;
        $name = isset($userInfo?->first_name, $userInfo?->last_name)
            ? $userInfo?->first_name . ' ' . $userInfo?->last_name
            : $userInfo?->name;

        $imagePath = userImagePath(authCheck()->guard);

        $storagePath = 'lms/' . $imagePath;
        $defaultCoverImage = 'lms/frontend/assets/images/870x260.svg';
        $defaultProfileImage = 'lms/assets/images/placeholder/profile.jpg';

        // Determine the profile image
        $coverImg =
            !empty($userInfo?->cover_photo) && fileExists($storagePath, $userInfo->cover_photo)
                ? 'storage/' . $storagePath . '/' . $userInfo->cover_photo
                : $defaultCoverImage;

        $profileImg =
            !empty($userInfo?->profile_img) && fileExists($storagePath, $userInfo->profile_img)
                ? 'storage/' . $storagePath . '/' . $userInfo->profile_img
                : $defaultProfileImage;

    @endphp

    <img src="{{ asset($coverImg) }}" alt="user-img" class="size-full object-cover">
    <div
        class="absolute left-1/2 -translate-x-1/2 -bottom-[calc(theme('spacing.ins-pro-img')_/_2)] w-[calc(theme('spacing.ins-pro-img')_+_5px)] h-[theme('spacing.ins-pro-img')] border-2 border-white dark:border-heading rounded-20 overflow-hidden dk-theme-card-square">
        <img src="{{ asset($profileImg) }}" class="size-full object-cover" alt="user-img">
    </div>
</div>
