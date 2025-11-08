@php
    $user = $instructor->userable ?? null;
    $profile_img = $user?->profile_img ?? '';

    $imgSrc =
        $profile_img && fileExists('lms/instructors', $profile_img) == true
            ? asset("storage/lms/instructors/{$profile_img}")
            : asset('lms/frontend/assets/images/370x396.svg');

    $userTranslations = parse_translation($user);
    $designationTranslations = parse_translation($user?->designation);

@endphp
<article>
    <h2 class="area-title xl:text-3xl mb-5">{{ translate('Instructor') }}</h2>
    <div class="flex flex-col md:flex-row gap-4 border border-border rounded-2xl p-7">
        <div class="size-44 overflow-hidden rounded-xl lg:rounded-50 shrink-0">
            <img data-src="{{ $imgSrc }}" alt="Instructor profile image" class="size-full object-cover">
        </div>
        <div class="grow">
            <h6 class="area-title text-xl !leading-none font-bold">
                {{ $userTranslations['first_name'] ?? $user?->first_name }}
                {{ $userTranslations['last_name'] ?? $user?->last_name }}
            </h6>
            <div class="text-heading/60 text-sm leading-none mt-1">
                {{ $designationTranslations['title'] ?? ($user?->designation?->title ?? '') }}
            </div>
            <a href="mailto:{{ $instructor?->email }}" class="text-sm text-primary">{{ $instructor?->email }}</a>
            @if ($user?->about)
                <div class="text-heading/70 font-semibold leading-[1.55] mt-6">
                    {!! clean($userTranslations['about'] ?? ($user->about ?? '')) !!}
                </div>
            @endif

            @if (isset($instructor['socials']) && $instructor['socials']->count() > 0)
                <!-- SOCIAL MEDIA -->
                <div class="flex items-center gap-4 w-max mt-5">
                    <div class="text-heading dark:text-white font-bold leading-none">
                        {{ translate('Follow') }} -
                    </div>
                    <x-theme::social.social-list-one :socials="$instructor['socials']" ulClass="flex items-center gap-2"
                        itemClass="size-10 rounded-50 bg-primary-50 text-heading/60 flex-center hover:bg-primary hover:text-white custom-transition" />
                </div>
            @endif
        </div>
    </div>
</article>
