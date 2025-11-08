<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="Organization Details" pageRoute="#" pageName="Organization Details" />
    @php
        $userInfo = $user->userable ?? null;

        $coverPhoto =
            $userInfo->cover_photo && fileExists('lms/organizations', $userInfo->cover_photo) == true
                ? asset("storage/lms/organizations/{$userInfo->cover_photo}")
                : asset('lms/frontend/assets/images/870x260.svg');

        $profileImg =
            $userInfo?->profile_img && fileExists('lms/organizations', $userInfo?->profile_img) == true
                ? asset("storage/lms/organizations/{$userInfo?->profile_img}")
                : asset('lms/frontend/assets/images/370x396.svg');

        $city = $user?->city?->name ?? null;

        if ($userInfo) {
            $userTranslations = parse_translation($userInfo);
        }

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

    <!-- START ORGANIZATION DETAILS AREA -->
    <div class="container">
        <div class="flex-center flex-col">
            <div class="w-full grow h-52 lg:h-64 bg-no-repeat bg-cover rounded-xl md:rounded-2xl"
                style="background-image: url({{ $coverPhoto }});"></div>
            <div class="w-full grow grid grid-cols-12 gap-5 px-[5vw] -mt-32 sm:-mt-20">
                <div class="col-span-full lg:col-span-8">
                    <div
                        class="h-full bg-white p-6 rounded-xl border border-r-border shadow-sm flex flex-col sm:flex-row items-center gap-6 shrink-0">
                        <div class="size-24 rounded-50 overflow-hidden border-2 border-white">
                            <img data-src="{{ $profileImg }}" alt="Organization profile image"
                                class="size-full object-cover">
                        </div>
                        <div class="grow">
                            <h5
                                class="relative area-title text-2xl !leading-none font-semibold hover:text-primary w-max">
                                {{ $name ?? $userInfo->name }}
                                @if ($user->is_verify)
                                    <img data-src="{{ asset('lms/frontend/assets/images/icons/verified.svg') }}"
                                        alt="Verified icon"
                                        class="absolute -top-1.5 -right-3.5 hidden [&.verified]:block verified"
                                        title="Verified">
                                @endif
                            </h5>
                            <p class="area-description !leading-none mt-2">{{ $cityName ?? '' }}
                                {{ $countryTranslations['name'] ?? ($user?->country?->name ?? '') }}
                            </p>
                            <div class="flex items-center gap-2 mt-4">
                                <a href="mailto:{{ $user->email }}" aria-label="Organization mail"
                                    class="btn b-outline btn-primary-outline btn-sm !rounded-full">
                                    <i class="ri-mail-send-line"></i>
                                    {{ translate('Send Email') }}
                                </a>
                                <a href="mailto:{{ $user->email }}" aria-label="Organization phone"
                                    class="btn b-solid btn-primary-solid btn-sm !rounded-full">
                                    <i class="ri-share-forward-line rtl:rotate-y-180"></i>
                                    {{ translate('Share') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-full lg:col-span-4">
                    <div class="h-full bg-white p-6 rounded-xl border border-r-border shadow-sm">
                        <ul
                            class="flex-center flex-col divide-y divide-border space-y-5 [&>:not(:first-child)]:pt-5 leading-none text-heading/70">
                            <li class="grow w-full flex flex-col gap-2 text-center sm:text-left">
                                <h6 class="area-title text-lg font-semibold !leading-none">
                                    {{ $rating['average_rating'] }}</h6>
                                <div
                                    class="flex items-center justify-center sm:justify-start rtl:sm:justify-end gap-0.5 text-secondary">
                                    {!! show_rating($rating['average_rating']) !!}
                                </div>
                            </li>
                            <li class="grow w-full flex flex-col gap-2 text-center sm:text-left">
                                <h6 class="area-title text-lg font-semibold !leading-none">
                                    {{ $courses->total() !== 0 ? $courses->total() . '+' : 0 }}
                                </h6>
                                <p class="area-description text-sm font-semibold !leading-none">
                                    {{ translate('Courses') }}</p>
                            </li>
                            <li class="grow w-full flex flex-col gap-2 text-center sm:text-left">
                                <h6 class="area-title text-lg font-semibold !leading-none">
                                    {{ $totalInstructors ? $totalInstructors . '+' : 0 }}</h6>
                                <p class="area-description text-sm font-semibold !leading-none">
                                    {{ translate('Total Instructors') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @if ($userInfo->about)
            <article class="mt-14">
                <h2 class="area-title xl:text-2xl mb-5">{{ translate('About Us') }}</h2>
                <div class="text-heading/70 font-semibold leading-[1.55] [&>:not(:first-child)]:mt-6 mt-6">
                    {!! clean($userTranslations['about'] ?? ($userInfo->about ?? '')) !!}
                </div>
            </article>
        @endif

    </div>
    <!-- END ORGANIZATION DETAILS AREA -->


    @if (isset($courses) && $courses->count() > 0)
        <!-- START MY COURSES AREA -->
        <div class="pt-16 sm:pt-24 lg:pt-[120px]">
            <div class="container">
                <!-- HEADER -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <div class="col-span-full text-center max-w-[594px] mx-auto">
                        <div class="area-subtitle">{{ translate('Popular Courses') }}</div>
                        <h2 class="area-title mt-2">
                            {{ translate('Explore Our') }}
                            <span class="title-highlight-one">{{ translate('Courses') }}</span>
                        </h2>
                    </div>
                </div>
                <!-- BODY -->
                <div class="col-span-full lg:col-span-8">
                    <div class="grid grid-cols-12 gap-4 xl:gap-7 mt-10">
                        <x-theme::cards.course-card-one :courses="$courses" borderClass="true" />
                    </div>
                    {!! $courses->links('theme::pagination.pagination-one') !!}
                </div>
            </div>
        </div>
        <!-- END MY COURSES AREA -->
    @endif
</x-frontend-layout>
