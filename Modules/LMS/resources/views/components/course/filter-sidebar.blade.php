@php
    $courseCategories = courseCategory() ?? [];
    $courseLanguages = courseLanguage() ?? [];
    $instructors = instructorCourse() ?? [];
    $levels = courseLevel() ?? [];
@endphp

<div class="col-span-full lg:col-span-4">
    <div id="filter-drawer"
        class="bg-black/50 fixed size-full inset-0 invisible opacity-0 duration-300 z-[99] lg:bg-transparent lg:relative lg:visible lg:opacity-100 lg:z-auto">
        <div
            class="filter-drawer-inner bg-white fixed inset-0 left-auto right-0 rtl:right-auto rtl:left-0 py-4 w-64 sm:w-80 translate-x-full duration-300 z-[100] lg:relative lg:right-auto lg:py-0 lg:w-full lg:translate-x-0 rtl:-translate-x-full rtl:lg:translate-x-0 lg:z-auto">
            <!-- CLOSE DRAWER -->
            <button type="button" aria-label="Course filter offcanvas close button"
                class="filter-drawer-close size-11 flex-center lg:hidden bg-white border border-transparent hover:border-primary absolute top-4 right-full rtl:right-auto rtl:left-full custom-transition">
                <i class="ri-close-line text-gray-500 dark:text-dark-text"></i>
            </button>
            <div class="flex flex-col gap-5 max-h-screen lg:max-h-full overflow-auto">
                <!-- FILTER ITEM -->
                <div class="bg-primary-50 p-6 rounded-none lg:rounded-xl lms-accordion">
                    <div class="search-keyword">
                        <label for="search_title" class="relative flex">
                            <span class="text-heading/60 absolute top-1/2 -translate-y-1/2 left-4 z-[1]">
                                <i class="ri-search-2-line"></i></span>
                            <input type="search" id="search_title" name="title"
                                placeholder="{{ translate('Search Here') }}..."
                                class="form-input text-heading/60 h-12 pl-10 bg-white">
                        </label>
                    </div>
                </div>
                <!-- FILTER ITEM -->
                <div class="bg-primary-50 rounded-none lg:rounded-xl lms-accordion">
                    <div
                        class="flex-center-between p-6 cursor-pointer lms-accordion-button panel-show group/accordion peer/accordion">
                        <h6 class="area-title text-xl !leading-none">
                            {{ translate('Price') }}
                        </h6>
                        <span class="group-[.panel-show]/accordion:-rotate-180">
                            <i class="ri-arrow-down-s-line"></i>
                        </span>
                    </div>
                    <ul
                        class="p-6 pt-3 border-t border-border lms-accordion-panel peer-[.panel-show]/accordion:block hidden">
                        <li class="flex items-center gap-2.5">
                            <label for="filter1" class="flex items-start gap-px cursor-pointer py-2.5">
                                <input type="radio" name="course_type" id="filter1"
                                    class="radio radio-primary mr-2.5 rtl:mr-0 rtl:ml-2.5 courseType" value="all">
                                <span class="text-heading dark:text-white font-medium leading-none">
                                    {{ translate('All course') }}
                                </span>

                            </label>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <label for="filter2" class="flex items-start gap-px cursor-pointer py-2.5">
                                <input type="radio" name="course_type" id="filter2"
                                    class="radio radio-primary mr-2.5 rtl:mr-0 rtl:ml-2.5 courseType" value="free">
                                <span class="text-heading dark:text-white font-medium leading-none">
                                    {{ translate('Free') }}
                                </span>

                            </label>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <label for="filter2Paid" class="flex items-start gap-px cursor-pointer py-2.5">
                                <input type="radio" name="course_type" id="filter2Paid"
                                    class="radio radio-primary mr-2.5 rtl:mr-0 rtl:ml-2.5 courseType" value="paid">
                                <span class="text-heading dark:text-white font-medium leading-none">
                                    {{ translate('Paid') }}
                                </span>

                            </label>
                        </li>
                    </ul>
                </div>
                <!-- FILTER ITEM -->
                <div class="bg-primary-50 rounded-none lg:rounded-xl lms-accordion">
                    <div
                        class="flex-center-between p-6 cursor-pointer lms-accordion-button panel-show group/accordion peer/accordion">
                        <h6 class="area-title text-xl !leading-none">
                            {{ translate('Categories') }}
                        </h6>
                        <span class="group-[.panel-show]/accordion:-rotate-180">
                            <i class="ri-arrow-down-s-line"></i>
                        </span>
                    </div>
                    <ul
                        class="p-6 pt-3 border-t border-border lms-accordion-panel peer-[.panel-show]/accordion:block hidden">
                        @if ($courseCategories->count() > 0)
                            @foreach ($courseCategories as $category)
                                @php
                                    $categoryTranslation = parse_translation($category);
                                @endphp

                                <li class="flex items-center gap-2.5">
                                    <label for="category{{ $category->id }}"
                                        class="flex items-start gap-px cursor-pointer py-2.5">
                                        <input type="checkbox" name="category_id" id="category{{ $category->id }}"
                                            class="checkbox checkbox-primary mr-2.5 rtl:mr-0 rtl:ml-2.5 filter-option category rounded-sm"
                                            value="{{ $category->id }}">
                                        <span
                                            class="text-heading dark:text-white font-medium leading-none">{{ $categoryTranslation['title'] ?? $category->title }}</span>
                                    </label>
                                </li>
                            @endforeach
                        @else
                            <li> {{ translate('No Category') }} </li>
                        @endif
                    </ul>
                </div>
                <!-- FILTER ITEM -->
                <div class="bg-primary-50 rounded-none lg:rounded-xl lms-accordion">
                    <div
                        class="flex-center-between p-6 cursor-pointer lms-accordion-button panel-show group/accordion peer/accordion">
                        <h6 class="area-title text-xl !leading-none">
                            {{ translate('Language') }}
                        </h6>
                        <span class="group-[.panel-show]/accordion:-rotate-180">
                            <i class="ri-arrow-down-s-line"></i>
                        </span>
                    </div>
                    <ul
                        class="p-6 pt-3 border-t border-border lms-accordion-panel peer-[.panel-show]/accordion:block hidden">
                        @if ($courseLanguages->count() > 0)
                            @foreach ($courseLanguages as $language)
                                @php
                                    $languageTranslation = parse_translation($language);
                                @endphp

                                <li class="flex items-center gap-2.5">
                                    <label for="language{{ $language->id }}"
                                        class="flex items-start gap-px cursor-pointer py-2.5">
                                        <input type="checkbox" name="checkbox" id="language{{ $language->id }}"
                                            class="checkbox checkbox-primary mr-2.5 rtl:mr-0 rtl:ml-2.5 filter-option language rounded-sm"
                                            value="{{ $language->id }}" name="language_id">
                                        <span
                                            class="text-heading dark:text-white font-medium leading-none">{{ $languageTranslation['name'] ?? $language->name }}</span>
                                    </label>
                                </li>
                            @endforeach
                        @else
                            <li>
                                {{ translate('No Language') }}
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- FILTER ITEM -->
                <div class="bg-primary-50 rounded-none lg:rounded-xl lms-accordion">
                    <div
                        class="flex-center-between p-6 cursor-pointer lms-accordion-button panel-show group/accordion peer/accordion">
                        <h6 class="area-title text-xl !leading-none">
                            {{ translate('Instructor') }}
                        </h6>
                        <span class="group-[.panel-show]/accordion:-rotate-180">
                            <i class="ri-arrow-down-s-line"></i>
                        </span>
                    </div>
                    <ul
                        class="p-6 pt-3 border-t border-border lms-accordion-panel peer-[.panel-show]/accordion:block hidden">
                        @if ($instructors->count() > 0)
                            @foreach ($instructors as $instructor)
                                @php
                                    $instructorTranslation = parse_translation($instructor?->userable);
                                @endphp

                                <li class="flex items-center gap-2.5">
                                    <label for="instructors{{ $instructor->id }}"
                                        class="flex items-start gap-px cursor-pointer py-2.5">
                                        <input type="checkbox" name="instructor_id"
                                            id="instructors{{ $instructor->id }}"
                                            class="checkbox checkbox-primary mr-2.5 rtl:mr-0 rtl:ml-2.5 filter-option instructors rounded-sm"
                                            value="{{ $instructor->id }}">
                                        <span
                                            class="text-heading dark:text-white font-medium leading-none">{{ $instructorTranslation['first_name'] ?? $instructor?->userable?->first_name }}

                                            {{ $instructorTranslation['last_name'] ?? $instructor?->userable?->last_name }}
                                        </span>

                                    </label>
                                </li>
                            @endforeach
                        @else
                            <li>
                                {{ translate('No Language') }}
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- FILTER ITEM -->
                <div class="bg-primary-50 rounded-none lg:rounded-xl lms-accordion">
                    <div
                        class="flex-center-between p-6 cursor-pointer lms-accordion-button panel-show group/accordion peer/accordion">
                        <h6 class="area-title text-xl !leading-none">{{ translate('Level') }}</h6>
                        <span class="group-[.panel-show]/accordion:-rotate-180">
                            <i class="ri-arrow-down-s-line"></i>
                        </span>
                    </div>
                    <ul
                        class="p-6 pt-3 border-t border-border lms-accordion-panel peer-[.panel-show]/accordion:block hidden">
                        @if ($levels->count() > 0)
                            @foreach ($levels as $level)
                                @php
                                    $levelTranslation = parse_translation($level);
                                @endphp
                                <li class="flex items-center gap-2.5">
                                    <label for="level{{ $level->id }}"
                                        class="flex items-start gap-px cursor-pointer py-2.5">
                                        <input type="checkbox" name="checkbox" id="level{{ $level->id }}"
                                            class="checkbox checkbox-primary mr-2.5 rtl:mr-0 rtl:ml-2.5 filter-option level rounded-sm"
                                            name="level_id" value="{{ $level->id }}">
                                        <span
                                            class="text-heading dark:text-white font-medium leading-none">{{ $levelTranslation['name'] ?? ($level->name ?? '') }}</span>
                                    </label>
                                </li>
                            @endforeach
                        @else
                            <li>
                                {{ translate('No Level') }}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
