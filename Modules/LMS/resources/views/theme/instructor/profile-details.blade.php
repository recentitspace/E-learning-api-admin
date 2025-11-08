@php
    $userInfo = $user->userable ?? null;

    if ($userInfo) {
        $userTranslations = parse_translation($userInfo);
    }

    $coverImg =
        $userInfo->cover_photo && fileExists('lms/instructors', $userInfo->cover_photo) == true
            ? asset("storage/lms/instructors/{$userInfo->cover_photo}")
            : asset('lms/frontend/assets/images/870x260.svg');

    $profileImg =
        $userInfo?->profile_img && fileExists('lms/instructors', $userInfo?->profile_img) == true
            ? asset("storage/lms/instructors/{$userInfo?->profile_img}")
            : asset('lms/frontend/assets/images/370x396.svg');

    if ($userTranslations) {
        $name = $userTranslations['first_name'] . ' ' . $userTranslations['last_name'];
    }
    if ($userInfo?->designation) {
        $designationData = parse_translation($userInfo?->designation);
    }

@endphp

<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="Instructor Profile" pageRoute="#" pageName="Instructor Profile" />

    <!-- START INSTRUCTOR PROFILE AREA -->
    <div class="container">
        <div class="flex-center flex-col">
            <div class="w-full h-28 md:h-52 bg-no-repeat bg-cover bg-center"
                style="background-image: url({{ $coverImg }});">
            </div>
            <div class="flex-center flex-col -mt-20 gap-2">
                <div class="size-40 md:size-44 rounded-50 overflow-hidden border-4 border-white">
                    <img data-src="{{ $profileImg }}" alt="Instructor profile image" class="size-full object-cover">
                </div>
                <h6 class="area-title text-xl !leading-none font-bold mt-2">
                    {{ $name ?? $userInfo->first_name . ' ' . $userInfo->last_name }}
                </h6>
                <ul
                    class="flex items-center flex-wrap gap-1.5 *:flex-center *:gap-1.5 leading-none text-heading/70 dark:text-dark-text">
                    <li
                        class="after:font-remix after:flex-center after:font-thin after:text-heading/70 after:size-5 after:content-['\f3c1'] after:text-[6px] after:translate-y-[1.4px] last:after:hidden">
                        {{ $user->courses?->count() ?? 0 }} {{ translate('Courses') }}
                    </li>

                    <li
                        class="after:font-remix after:flex-center after:font-thin after:text-heading/70 after:size-5 after:content-['\f3c1'] after:text-[6px] after:translate-y-[1.4px] last:after:hidden">
                        {{ !empty($totalStudents) && $totalStudents?->count() ?? 0 }} {{ translate('Students') }}
                    </li>
                </ul>
                <ul
                    class="flex items-center flex-wrap gap-1.5 *:flex-center *:gap-1.5 leading-none text-heading/70 dark:text-dark-text">
                    <li
                        class="after:font-remix after:flex-center after:font-thin after:text-heading/70 after:size-5 after:content-['\f3c1'] after:text-[6px] after:translate-y-[1.4px] last:after:hidden">
                        <div class="flex items-center gap-0.5 text-secondary">
                            {!! show_rating($rating['average_rating']) !!}
                        </div>
                        <p class="area-description text-sm !leading-none">
                            {{ $rating['total'] ?? 0 }}</p>
                    </li>
                    <li
                        class="after:font-remix after:flex-center after:font-thin after:text-heading/70 after:size-5 after:content-['\f3c1'] after:text-[6px] after:translate-y-[1.4px] last:after:hidden">
                        {{ $designationData['title'] ?? ($userInfo?->designation?->title ?? '') }}
                    </li>
                </ul>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-5 mt-10 lg:mt-[60px]">
            <div class="col-span-full lg:col-span-6">
                <div class="border border-border rounded-2xl p-7">
                    <article>
                        <h2 class="area-title xl:text-3xl mb-5">{{ translate('Biography') }}</h2>
                        <div class="text-heading/70 font-semibold leading-[1.55] [&>:not(:first-child)]:mt-6 mt-6">
                            {!! clean($userTranslations['about'] ?? ($userInfo->about ?? '')) !!}
                        </div>
                        <!-- SOCIAL MEDIA -->
                        <ul class="flex flex-col gap-4 mt-10">
                            <li>
                                <a href="mailto:{{ $user->email }}" aria-label="Instructor mail"
                                    class="flex items-center gap-2 text-primary leading-none">
                                    <i class="ri-mail-send-line"></i>
                                    <span class="text-heading"> {{ $user->email }}</span>
                                </a>
                            </li>
                            @if ($user->phone)
                                <li>
                                    <a href="tel+{{ $user->phone }}" aria-label="Instructor phone"
                                        class="flex items-center gap-2 text-primary leading-none">
                                        <i class="ri-phone-line"></i>
                                        <span class="text-heading">+ {{ $user->phone }}</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </article>
                </div>
            </div>
            <div class="col-span-full lg:col-span-6">
                <div class="border border-border rounded-2xl p-7">
                    <h2 class="area-title xl:text-3xl mb-5">{{ translate('Contact Form') }}</h2>
                    <x-theme::contact-form.form userId="{{ $user->id }}" />
                </div>
            </div>
        </div>
    </div>
    <!-- END INSTRUCTOR PROFILE AREA -->

    <!-- START MY COURSES AREA -->
    @php
        $courses = $courses ?? [];
    @endphp
    @if ($courses && count($courses) > 0)
        <x-theme::instructor.my-course :courses="$courses ?? []" />
    @endif
</x-frontend-layout>
