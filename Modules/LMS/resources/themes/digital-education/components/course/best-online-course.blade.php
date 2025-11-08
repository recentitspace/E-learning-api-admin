@php
    $courses = $courses ?? [];
    $courseCategories = $courseCategories ?? [];
@endphp

<div class="bg-section relative py-16 sm:py-24 lg:py-[120px] mt-16 sm:mt-24 lg:mt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-6">
                <div class="area-subtitle subtitle-outline style-three !text-secondary">
                    {{ translate('Online Courses') }}</div>
                <h2 class="area-title mt-1">
                    {{ translate('Best Online Courses') }}
                </h2>
            </div>
            @if (!empty($courseCategories) && is_iterable($courseCategories))
                <div class="col-span-full md:col-span-6 justify-self-end">
                    <div class="dashkit-tab flex items-center flex-wrap gap-1" id="onlineCourseTab">
                        <button
                            type="button"
                            aria-label="Online course category tab"
                            class="dashkit-tab-btn btn hover:bg-secondary hover:text-white [&.active]:bg-secondary [&.active]:text-white capitalize active"
                            id="all-courses">{{ translate('All') }}</button>
                        @foreach ($courseCategories as $courseCategory)
                            @php $categoryTranslations = parse_translation($courseCategory); @endphp
                            <button
                                type="button"
                                aria-label="Online course category tab"
                                class="dashkit-tab-btn btn hover:bg-secondary hover:text-white [&.active]:bg-secondary [&.active]:text-white capitalize"
                                id="{{ $courseCategory->slug }}">{{ $categoryTranslations['title'] ?? $courseCategory->title ?? '' }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <!-- BODY -->
        @if (!empty($courses) && is_iterable($courses))
            <div class="mt-[60px]">
                <div class="dashkit-tab-content *:hidden" id="onlineCourseTabContent">
                    <div class="dashkit-tab-pane !block" data-tab="all-courses">
                        <div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7">
                            @foreach ($courses as $course)
                                <x-theme::cards.course.card-four :course="$course" tab="all-courses" />
                            @endforeach
                        </div>
                    </div>
                    @foreach ($courseCategories as $courseCategory)
                        <div class="dashkit-tab-pane" data-tab="{{ $courseCategory->slug }}">
                            @php $count = 0; @endphp
                            <div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7">
                                @foreach ($courses as $course)
                                    @if ($course?->category?->slug === $courseCategory->slug)
                                        @php $count++; @endphp
                                        <x-theme::cards.course.card-four :course="$course"
                                            tab="{{ $courseCategory->slug }}" />
                                    @endif
                                @endforeach
                            </div>

                            @if (0 === $count)
                                <div class="bg-white border border-border rounded-xl h-[400px] shadow-md">
                                    <div
                                        class="flex-center flex-col gap-4 p-6 text-center max-w-screen-sm mx-auto h-full">
                                        <h2 class="area-title xl:text-3xl">{{ translate('Oops, Nothing Here Yet!') }}
                                        </h2>
                                        <p class="area-description">
                                            {{ translate("It looks like we don't have any courses in this category right now. Feel free to browse other categories or let us know if there's something specific you'd like to learn!") }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="mt-[60px] bg-white border border-border rounded-xl h-[400px] shadow-md">
                <div class="flex-center flex-col gap-4 p-6 text-center max-w-screen-sm mx-auto h-full">
                    <h2 class="area-title xl:text-3xl">{{ translate('Oops, Nothing Here Yet!') }}</h2>
                    <p class="area-description">
                        {{ translate("It looks like we don't have any courses right now. Feel free to browse other or let us know if there's something specific you'd like to learn!") }}
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
