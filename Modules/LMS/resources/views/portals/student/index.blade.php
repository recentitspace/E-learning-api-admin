@php
    $translations = parse_translation(authCheck()?->userable);
@endphp

<x-dashboard-layout>
    <x-slot:title> {{ translate('My Course') }} </x-slot:title>
    <div class="grid grid-cols-12 gap-x-4">
        <!-- Start Intro -->
        <div class="col-span-full 2xl:col-span-7 card p-0">
            <div class="grid grid-cols-12 px-5 sm:px-12 py-11 relative overflow-hidden h-full">
                <div class="col-span-full md:col-span-7 self-center inline-flex flex-col 2xl:block">
                    <p class="today !leading-none text-sm lg:text-base text-gray-900">
                        {{ translate('Today is') }}
                        {{ customDateFormate(now(), 'd M Y') }}
                    </p>
                    <h1 class="text-heading dark:text-white text-4xl xl:text-[42px] leading-[1.23] font-semibold mt-3">
                        <span class="flex-center justify-start">
                            <span class="shrink-0"> {{ translate('Welcome Back') }} .</span>
                            <span
                                class="select-none hidden md:inline-block animate-hand-wave origin-[70%_70%]">👋</span><br>
                        </span>
                        {{ $translations['first_name'] ?? authCheck()?->userable?->first_name }}
                    </h1>

                </div>
                <div class="col-span-full md:col-span-5 flex-col items-center justify-center 2xl:block hidden md:flex">
                    <img src="{{ asset('lms/assets/images/loti/loti-admin-dashboard.svg') }}" alt="online-workshop"
                        class="hidden group-[.light]:block">
                    <img src="{{ asset('lms/assets/images/loti/loti-admin-dashboard.svg') }}" alt="online-workshop"
                        class="hidden group-[.dark]:block">
                </div>
                <!-- Graphicla Elements -->
                <ul>
                    <li class="absolute -top-[30px] left-1/2 animate-spin-slow">
                        <img src="{{ asset('lms/assets/images/element/graphical-element-1.svg') }}" alt="element">
                    </li>
                    <li class="absolute -bottom-[24px] left-1/4 animate-spin-slow">
                        <img src="{{ asset('lms/assets/images/element/graphical-element-2.svg') }}" alt="element">
                    </li>
                </ul>
            </div>
        </div>
        <!-- End Intro -->

        <!-- Start Student Couse Overview -->
        <div class="col-span-full 2xl:col-span-5 mb-4">
            <div class="grid grid-cols-12 gap-4 h-full">
                <div class="col-span-full md:col-span-6 card p-5 mb-0">
                    <div
                        class="size-11 flex-center bg-[#F7F3FF] dark:bg-dark-icon rounded-10 dk-theme-card-square mb-4">
                        <img src="{{ asset('lms/assets/images/icons/course-overview/progress.svg') }}" alt="icon"
                            class="dark:brightness-[5]">
                    </div>
                    <p class="text-gray-500 dark:text-dark-text font-medium leading-none mb-2">
                        {{ translate('Course in progress') }}
                    </p>
                    <div class="counter-value text-primary-500 text-[32px] font-semibold leading-none"
                        data-value="{{ $data['totalProcessing'] }}">
                        {{ $data['totalProcessing'] ?? 0 }}
                    </div>
                </div>
                <div class="col-span-full md:col-span-6 card p-5 mb-0">
                    <div
                        class="size-11 flex-center bg-[#F7F3FF] dark:bg-dark-icon rounded-10 dk-theme-card-square mb-4">
                        <img src="{{ asset('lms/assets/images/icons/course-overview/complete.svg') }}" alt="icon"
                            class="dark:brightness-[5]">
                    </div>
                    <p class="text-gray-500 dark:text-dark-text font-medium leading-none mb-2">
                        {{ translate('Completed course') }}
                    </p>
                    <div class="counter-value text-primary-500 text-[32px] font-semibold leading-none"
                        data-value="{{ $data['totalCompleted'] }}">
                        {{ $data['totalCompleted'] ?? 0 }}
                    </div>
                </div>
                <div class="col-span-full md:col-span-6 card p-5 mb-0">
                    <div
                        class="size-11 flex-center bg-[#F7F3FF] dark:bg-dark-icon rounded-10 dk-theme-card-square mb-4">
                        <img src="{{ asset('lms/assets/images/icons/course-overview/purchase.svg') }}" alt="icon"
                            class="dark:brightness-[5]">
                    </div>
                    <p class="text-gray-500 dark:text-dark-text font-medium leading-none mb-2">
                        {{ translate('Enrolled Course') }}
                    </p>
                    <div class="counter-value text-primary-500 text-[32px] font-semibold leading-none"
                        data-value="{{ $data['totalEnrolled'] ?? 0 }}">
                        {{ $data['totalEnrolled'] ?? 0 }}
                    </div>
                </div>
                <div class="col-span-full md:col-span-6 card p-5 mb-0">
                    <div
                        class="size-11 flex-center bg-[#F7F3FF] dark:bg-dark-icon rounded-10 dk-theme-card-square mb-4">
                        <img src="{{ asset('lms/assets/images/icons/course-overview/certificate.svg') }}"
                            alt="icon" class="dark:brightness-[5]">
                    </div>
                    <p class="text-gray-500 dark:text-dark-text font-medium leading-none mb-2">
                        {{ translate('Certificate') }}
                    </p>
                    <div class="counter-value text-primary-500 text-[32px] font-semibold leading-none"
                        data-value="{{ $data['totalCertificate'] ?? 0 }}">

                        {{ $data['totalCertificate'] ?? 0 }}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Student Couse Overview -->


        <!-- Start Student Course List Table -->
        <div class="col-span-full 2xl:col-span-12 card lg:order-2 2xl:order-none">
            <h6 class="card-title mb-6">{{ translate('Latest Enrolled course') }}</h6>
            @if (isset($data['enrolled']) && count($data['enrolled']) > 0)
                <!-- Course Table -->
                <div class="overflow-x-auto scrollbar-table">
                    <table
                        class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                        <thead>
                            <tr>
                                <th
                                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                    {{ translate('Course title') }}
                                </th>
                                <th
                                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                    {{ translate('Course Category') }}
                                </th>
                                <th
                                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                    {{ translate('Price') }}
                                </th>
                                <th
                                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                    {{ translate('Status') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                            @foreach ($data['enrolled'] as $enrolled)
                                @if ($enrolled->purchase_type == 'course')
                                    <x-portal::student.enrolled-course :enrolled="$enrolled" />
                                @else
                                    <x-portal::student.enrolled-bundle :enrolled="$enrolled" />
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <!-- End Student Course List Table -->
    </div>
</x-dashboard-layout>
