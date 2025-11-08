@php

    $isOrganization = isOrganization();
    $isAdmin = isAdmin();
    $isInstructor = isInstructor();
    $currentUser = authCheck();

    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    $course = $course ?? null;
    if ($course && $locale) {
        $translations = parse_translation($course, $locale);
    }
    $type = $type ?? '';
@endphp

<!-- Start Basic -->
<div class="fieldset !block">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="basic" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <div class="grid grid-cols-12 gap-x-4">
            <!-- LEFT AREA -->
            <div class="col-span-full lg:col-span-6 card">
                <div class="leading-none">
                    <label for="courseTitle" class="form-label">
                        {{ translate('How about a course title') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" name="title" value="{{ $translations['title'] ?? ($course->title ?? '') }}"
                        placeholder="{{ translate('Course Title') }}" class="form-input">
                    <span class="text-danger error-text title_err"></span>
                </div>

                <div class="leading-none mt-6">
                    <label for="courseCategory" class="form-label">
                        {{ translate('Courses category') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select name="category_id" id="courseCategory"
                        class="list-border-primary px-5 py-[17.5px] wide leading-none border border-input-border rounded-10 text-gray-900 font-spline_sans [&.open]:border-primary-400">
                        <option></option>
                        @foreach (get_all_category(locale: $locale) as $category)
                            @php $categoryTranslations = parse_translation($category, $locale); @endphp
                            <option value="{{ $category->id }}"
                                {{ isset($course) && $course->category_id == $category->id ? 'selected' : '' }}>
                                {{ $categoryTranslations['title'] ?? ($category->title ?? '') }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text category_id_err"></span>
                </div>
                @if (!$isOrganization)
                    <div class="leading-none mt-6">
                        <label for="courseInstructor" class="form-label"> {{ translate('Organization') }} </label>
                        <select
                            class="js-example-basic-single form-input px-5 py-4 rounded-10  {{ $isAdmin || $isOrganization ? 'organization-list' : '' }} "
                            name="organization_id" data-locale="{{ $locale }}">
                            <option value="no-select"> {{ translate('Select Organization') }} </option>
                            @foreach (get_all_organization(locale: $locale) as $organization)
                                @php
                                    $orgUser = $organization?->userable;
                                    $orgTranslations = parse_translation($orgUser, $locale);
                                @endphp
                                <option value="{{ $organization->id }}"
                                    {{ isset($course) && $course->organization_id == $organization->id ? 'selected' : '' }}>
                                    {{ $orgTranslations['name'] ?? $orgUser?->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if ($isAdmin || $isOrganization)
                    <div class="leading-none mt-6">
                        <label class="form-label">
                            {{ translate('Instructor') }}
                            <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                        </label>
                        <select class="js-example-basic-single" name="instructors[]" id="instructorOption" multiple>
                            <option disabled>{{ translate('Select Instructor') }}</option>

                            @foreach (get_all_instructor($currentUser->id ?? null, locale: $locale) as $instructor)
                                @php
                                    $insUser = $instructor?->userable;
                                    $userTranslations = parse_translation($insUser, $locale);
                                @endphp
                                <option value="{{ $instructor->id }}"
                                    @if (isset($course, $course->instructors) && !empty($course->instructors)) @foreach ($course->instructors as $cinstructor)
                                             {{ $cinstructor->id == $instructor->id ? 'selected' : '' }}
                                    @endforeach @endif>
                                    {{ $userTranslations['first_name'] ?? $insUser?->first_name }}
                                    {{ $userTranslations['last_name'] ?? $insUser?->last_name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text instructors_err"></span>
                    </div>
                @endif

                @if ($isInstructor)
                    <input type="hidden" name="instructors[]" value="{{ $currentUser->id }}">
                @endif
                @if ($isOrganization)
                    <input type="hidden" name="organization_id" value="{{ $currentUser->id }}">
                @endif
                <div class="leading-none mt-6">
                    <label for="courseLevel" class="form-label">
                        {{ translate('Courses level') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select name="levels[]" multiple="true" id="courseLevel"
                        class="level-list list-border-primary px-5 py-[17.5px] wide leading-none border border-input-border rounded-10 text-gray-900 font-spline_sans [&.open]:border-primary-400">
                        @foreach (get_all_level(locale: $locale) as $level)
                            @php $levelTranslations = parse_translation($level, $locale); @endphp
                            <option value="{{ $level->id }}"
                                @if (isset($course, $course->levels) && !empty($course->levels)) @foreach ($course->levels as $clevel)
                                            {{ $clevel->id == $level->id ? 'selected' : '' }} @endforeach @endif>
                                {{ $levelTranslations['name'] ?? ($level->name ?? '') }}
                            </option>
                        @endforeach
                    </select>

                    <span class="text-danger error-text levels_err"></span>
                </div>
                @php
                    $src_type = $course->video_src_type ?? null;
                @endphp
                <div class="leading-none mt-6">
                    <label class="form-label">
                        {{ translate('Course Demo Video Source') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select class="singleSelect" name="video_src_type" id="source-type-select">
                        <option disabled selected>{{ translate('Select Source Type') }}</option>
                        <option value="youtube" {{ $src_type == 'youtube' ? 'selected' : '' }}>
                            {{ translate('Youtube') }}</option>
                        <option value="vimeo" {{ $src_type == 'vimeo' ? 'selected' : '' }}>{{ translate('Vimeo') }}
                        </option>
                        <option value="local" {{ $src_type == 'local' ? 'selected' : '' }}>{{ translate('Local') }}
                        </option>
                    </select>
                    <span class="text-danger error-text video_src_type_err"></span>
                    <div id="courseVideoFile" class="mt-4">
                        @if (isset($course, $src_type) && $src_type !== 'local')
                            <label class="form-label">
                                {{ translate('Video url') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <input type="url" class="form-input" placeholder="{{ translate('Video url') }}"
                                value="{{ $course->demo_url ?? '' }}" name="demo_url" autocomplete="off" />
                        @elseif (isset($course) && $src_type == 'local')
                            <label class="form-label">
                                {{ translate('Upload File') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <div class="border border-input-border rounded-md px-2 py-1.5">
                                <input type="file" class="w-full" name="short_video">
                            </div>
                            <span class="text-danger error-text short_video_err"></span>
                            @if (isset($course))
                                <div class="video mt-4">
                                    @if (fileExists($folder = 'lms/courses/demo-videos', $fileName = $course->short_video) == true &&
                                            $course->short_video !== '')
                                        <video width="320" height="240" controls autoplay>
                                            <source
                                                src="{{ asset('storage/lms/courses/demo-videos/' . $course->short_video) }}">
                                        </video>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="leading-none mt-6">
                    <label for="subject" class="form-label">
                        {{ translate('Subject') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select name="subject_id" id="subject"
                        class="singleSelect list-border-primary px-5 py-[17.5px] wide leading-none border border-input-border rounded-10 text-gray-900 font-spline_sans [&.open]:border-primary-400">
                        <option selected disabled>{{ translate('Select subject') }}</option>
                        @foreach (get_all_subject(locale: $locale) as $subject)
                            @php $subjectTranslations = parse_translation($subject, $locale); @endphp
                            <option value="{{ $subject->id }}"
                                {{ isset($course) && $course->subject_id == $subject->id ? 'selected' : '' }}>
                                {{ $subjectTranslations['name'] ?? ($subject->name ?? '') }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text subject_id_err"></span>
                </div>
            </div>
            <!-- RIGHT AREA -->
            <div class="col-span-full lg:col-span-6 card">
                <div class="leading-none">
                    <label for="courseLanguage" class="form-label">
                        {{ translate('Language') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select name="languages[]" multiple="true" id="courseLanguage"
                        class="language-list list-border-primary px-5 py-[17.5px] wide leading-none border border-input-border rounded-10 text-gray-900 font-spline_sans [&.open]:border-primary-400">
                        @foreach (get_all_language(locale: $locale) as $language)
                            @php $languageTranslations = parse_translation($language, $locale); @endphp
                            <option value="{{ $language->id }}"
                                @if (isset($course, $course->languages) && !empty($course->languages)) @foreach ($course->languages as $clanguage)
                                            {{ $clanguage->id == $language->id ? 'selected' : '' }} @endforeach @endif>
                                {{ $languageTranslations['name'] ?? ($language->name ?? '') }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text languages_err"></span>
                </div>
                <div class="leading-none mt-6">
                    <label for="zone" class="form-label">
                        {{ translate('Time Zone') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select name="time_zone_id"
                        class="zone-list list-border-primary px-5 py-[17.5px] wide leading-none border border-input-border rounded-10 text-gray-900 font-spline_sans [&.open]:border-primary-400">
                        <option></option>
                        @foreach (get_all_zones() as $zone)
                            <option value="{{ $zone->id }}"
                                {{ isset($course) && $course->time_zone_id == $zone->id ? 'selected' : '' }}>
                                {{ $zone->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text time_zone_id_err"></span>
                </div>
                <div class="leading-none mt-6">
                    <label for="courseDuration" class="form-label">
                        {{ translate('Course duration') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" id="courseDuration" name="duration" value="{{ $course->duration ?? '' }}"
                        placeholder="{{ translate('Topic duration') }}" class="form-input">
                    <span class="text-danger error-text duration_err"></span>
                </div>

                <div class="leading-none mt-6">
                    <label for="courseDuration" class="form-label">
                        {{ translate('Short Description') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <textarea name="short_description" class="form-input" rows="6">{{ $translations['short_description'] ?? ($course->short_description ?? '') }}</textarea>
                    <span class="text-xs text-danger inline-block mt-1"><strong>{{ translate('Recommended') }}
                            :</strong>
                        {{ translate('Word between - 120 to 150') }}</span>
                    <p class="text-danger error-text short_description_err"></p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-{{ isset($course) ? '12' : '8' }} card">
                <label class="form-label">
                    {{ translate('Description') }}
                    <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                </label>
                <textarea name="description" class="summernote">{!! clean($translations['description'] ?? ($course->description ?? '')) !!}</textarea>
                <span class="text-danger error-text description_err"></span>
            </div>
            @if (!isset($course))
                <div class="col-span-full lg:col-span-4 card">
                    <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                        {{ translate('Thumbnail') }}(300 x300 )
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </p>
                    <label for="thumbnail"
                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                        <input type="file" hidden name="thumbnail" id="thumbnail"
                            class="dropzone dropzone-image img-src peer/file">
                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                            <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}" alt="file-icon"
                                class="size-8 lg:size-auto">
                            <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }}
                            </div>
                        </span>
                    </label>
                    <div class="preview-zone dropzone-preview">
                        <div class="box box-solid">
                            <div class="box-body flex items-center gap-2 flex-wrap">
                                @if (isset($course) && fileExists('lms/courses/thumbnails', $course?->thumbnail) == true && $course?->thumbnail !== '')
                                    <div class="img-thumb-wrapper">
                                        <img class="img-thumb" width="100"
                                            src="{{ asset('storage/lms/courses/thumbnails/' . $course->thumbnail) }}" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="text-danger error-text thumbnail_err"></span>
                </div>
            @endif
        </div>
        <div class="card flex-center gap-4 justify-end">
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                @if ($type == 'translations')
                    {{ translate('Save') }}
                @else
                    {{ !isset($course) ? translate('Save') : translate('Save & Continue') }}
                @endif
            </button>
        </div>
    </form>
</div>
