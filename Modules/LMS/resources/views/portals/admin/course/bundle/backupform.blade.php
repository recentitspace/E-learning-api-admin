@php
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    $bundle = $bundle ?? null;
    if ($bundle && $locale) {
        $translations = parse_translation($bundle, $locale);
    }
    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $platformFee = $backendSetting['platform_fee'] ?? 0;
    $bundlePrice = isset($bundle) ? $bundle->price - $bundle->platform_fee : null;
    $isOrganization = isOrganization();
    $isAdmin = isAdmin();
@endphp
<x-dashboard-layout>
    <x-slot:title>{{ isset($language) ? translate('Edit') : translate('Create') }}
        {{ translate('Bundle') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('bundle.index') }}"
        title="{{ isset($language) ? 'Edit' : 'Create' }} Bundle" page-to="Bundle" />

    <div class="card">
        <div class="container relative">
            <button
                class="prev-step-btn btn-icon b-solid btn-primary-icon-solid opacity-40 hover:opacity-100 absolute top-1/2 -left-4 -translate-y-1/2">
                <i class="ri-arrow-left-circle-line text-inherit text-[24px]"></i>
            </button>
            <div
                class="stepper-menu flex items-center text-center overflow-hidden scroll-smooth [&.dragging]:scroll-auto [&.dragging]:cursor-grab group/stepper-menu">
                <button type="button" class="stepper-step-btn">
                    <i class="ri-stack-line text-inherit"></i>
                    {{ translate('Basic') }}
                </button>
                <button type="button" class="stepper-step-btn active">
                    <i class="ri-image-2-line text-inherit"></i>
                    {{ translate('Media') }}
                </button>
                <button type="button" class="stepper-step-btn">
                    <i class="ri-price-tag-2-line text-inherit"></i>
                    {{ translate('Price') }}
                </button>
                <button type="button" class="stepper-step-btn">
                    <i class="ri-information-line text-inherit"></i>
                    {{ translate('Course') }}
                </button>
                <button type="button" class="stepper-step-btn active">
                    <i class="ri-settings-3-line text-inherit"></i>
                    {{ translate('Extra Information') }}
                </button>

                <button type="button" class="stepper-step-btn active">
                    <i class="ri-settings-3-line text-inherit"></i>
                    {{ translate('Setting') }}
                </button>
                <button type="button" class="stepper-step-btn">
                    <i class="ri-flag-line text-inherit"></i>
                    {{ translate('Finish') }}
                </button>
            </div>
            <button
                class="next-step-btn btn-icon b-solid btn-primary-icon-solid opacity-40 hover:opacity-100 absolute top-1/2 -right-4 -translate-y-1/2">
                <i class="ri-arrow-right-circle-line text-inherit text-[24px]"></i>
            </button>
        </div>
    </div>
    <div class="mb-4">
        <div id="msform" class="*:hidden">
            <div class="fieldset">
                {{-- @if (is_active('bundle.translate') === 'active')
                    <div class="flex items-center justify-end gap-4 mb-2">
                        <h2 class="card-title">{{ translate('Translate Language') }}</h2>
                        <form method="GET" class="sm:block" id="change-translate-language">
                            <select onchange="window.location.href=this.options[this.selectedIndex].value"
                                name="id"
                                class="text-gray-500 dark:text-dark-text dark:bg-dark-card-shade font-semibold bg-white focus:outline-none cursor-pointer select-none text-sm border dk-border-one px-2 py-2 rounded-md dk-theme-card-square">
                                @foreach (app('languages') as $lang)
                                    <option value="{{ $lang->code }}"
                                        {{ isset($locale) && $locale == $lang->code ? 'selected' : '' }}>
                                        {{ $lang->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                @endif --}}
                <form action="{{ isset($bundle) ? route('bundle.update', $bundle->id) : route('bundle.store') }}"
                    class="mb-4 form" method="POST" enctype="multipart/form-data">
                    @if (isset($bundle))
                        @method('PUT')
                        <input type="hidden" id="id" value="{{ $bundle->id }}">
                    @endif
                    @csrf
                    <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
                    <div class="grid grid-cols-12 gap-x-4">
                        <div
                            class="col-span-full {{ is_active('bundle.translate') !== 'active' ? 'lg:col-span-6' : '' }} card">

                            <div class="mt-7">
                                <div class="mt-6">
                                    <label for="bundle-title" class="form-label"> {{ translate('Title') }}
                                        <span class="text-danger"
                                            title="{{ translate('This field is required') }}"><b>*</b></span>
                                    </label>
                                    <input type="text" id="bundle-title" placeholder="{{ translate('Title') }}"
                                        class="form-input" name="title"
                                        value="{{ $translations['title'] ?? ($bundle->title ?? '') }}">
                                    <span class="text-danger error-text title_err"></span>
                                </div>
                                {{-- @if (is_active('bundle.translate') !== 'active')
                                    <div class="grid grid-cols-12 gap-4">
                                        <div class="col-span-full lg:col-span-3">
                                            <div class="mt-6">
                                                <label for="currency" class="form-label">{{ translate('Currency') }}
                                                    <span class="text-danger"
                                                        title="{{ translate('This field is required') }}"><b>*</b></span>
                                                </label>
                                                <select data-select id="currency" name="currency" class="singleSelect">
                                                    <option selected disabled
                                                        data-display="{{ translate('Select Currency') }}">
                                                        {{ translate('Select Currency') }} </option>
                                                    @foreach (all_currency() as $currency)
                                                        @php
                                                            $codeSymbol = $currency->code . '-' . $currency->symbol;
                                                        @endphp
                                                        <option value="{{ $currency->code . '-' . $currency->symbol }}"
                                                            {{ isset($bundle) && $bundle?->currency == $codeSymbol ? 'selected' : '' }}>
                                                            {{ $currency->symbol }} - {{ $currency->code }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text currency_err"></span>
                                            </div>
                                        </div>

                                        <div class="col-span-full lg:col-span-4">
                                            <div class="mt-6">
                                                <label for="price" class="form-label"> {{ translate('Price') }}
                                                    <span class="text-danger"
                                                        title="{{ translate('This field is required') }}"><b>*</b></span>
                                                </label>
                                                <input type="number" placeholder="{{ translate('Your Price') }}"
                                                    class="form-input bundle-price-cal"
                                                    value="{{ $bundlePrice ?? '' }}" id="price">

                                            </div>
                                        </div>
                                        <div class="col-span-full lg:col-span-3">
                                            <div class="mt-6">
                                                <label for="platform_fee" class="form-label">
                                                    {{ translate('Platform Price') }}
                                                    <span class="text-danger"
                                                        title="{{ translate('This field is required') }}"><b>*</b></span>
                                                </label>

                                                <input type="hidden"value="{{ $platformFee ?? '' }}"
                                                    name="platform_fee">
                                                <input type="number" id="platform_fee"
                                                    placeholder="{{ translate('Platform Price') }}" disabled
                                                    class="form-input disabled:!text-heading"
                                                    value="{{ $platformFee ?? '' }}" placeholder="Platform Price">
                                                <span class="text-danger error-text title_err"></span>

                                            </div>
                                        </div>
                                        <div class="col-span-full lg:col-span-2">
                                            <div class="mt-6">
                                                <label for="total_price"
                                                    class="form-label">{{ translate('Total Price') }}
                                                    <span class="text-danger"
                                                        title="{{ translate('This field is required') }}"><b>*</b></span>
                                                </label>
                                                <input type="number" id="total_price"
                                                    placeholder="{{ translate('Bundle Price') }}" name="price"
                                                    class="form-input"
                                                    value="{{ $bundlePrice + $platformFee ?? '' }}">
                                                <span class="text-danger error-text  price_err"></span>
                                            </div>

                                        </div>
                                    </div>
                                @endif --}}
                                {{-- <div class="mt-6">
                                    <label for="coupon-type" class="form-label">
                                        {{ translate('Select Course') }}
                                        <span class="text-danger"
                                            title="{{ translate('This field is required') }}"><b>*</b></span>
                                    </label>
                                    <select class="multipleSelect form-input" multiple="multiple" name="courseId[]">
                                        @foreach (get_all_course() as $course)
                                            @php $courseTranslations = parse_translation($course, $locale); @endphp
                                            <option value="{{ $course->id }}"
                                                @if (isset($bundle) && $bundle?->courses?->count() > 0) @foreach ($bundle?->courses as $bcourse)
                                        {{ $bcourse->id == $course->id ? 'selected' : '' }}
                                    @endforeach @endif>
                                                {{ $courseTranslations['title'] ?? ($course->title ?? '') }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text courseId_err"></span>
                                </div> --}}
                            </div>

                            <div class="leading-none mt-6">
                                <label for="courseCategory" class="form-label">
                                    {{ translate('Courses category') }}
                                    <span class="text-danger"
                                        title="{{ translate('This field is required') }}"><b>*</b></span>
                                </label>
                                <select name="category_id" id="courseCategory"
                                    class="list-border-primary px-5 py-[17.5px] wide leading-none border border-input-border rounded-10 text-gray-900 font-spline_sans [&.open]:border-primary-400">
                                    <option></option>
                                    @foreach (get_all_category() as $category)
                                        @php $categoryTranslations = parse_translation($category, $locale); @endphp
                                        <option value="{{ $category->id }}"
                                            {{ isset($course) && $course->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $categoryTranslations['title'] ?? ($category->title ?? '') }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text category_id_err"></span>
                            </div>


                        </div>
                        @if (is_active('bundle.translate') !== 'active')
                            <div class="col-span-full lg:col-span-6 card">
                                {{-- <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Media') }}
                                </h6>
                                <div class="mt-7">
                                    <p
                                        class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                                        {{ translate('Thumbnail') }} ({{ translate('300') }}x{{ translate('300') }})
                                    </p>
                                    <label for="thumbnail"
                                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                        <input type="file" hidden name="image" id="thumbnail"
                                            class="dropzone dropzone-image img-src peer/file">

                                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                            <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                                                alt="file-icon" class="size-8 lg:size-auto">
                                            <div class="text-gray-500 dark:text-dark-text mt-2">
                                                {{ translate('Choose file') }}
                                            </div>
                                        </span>
                                    </label>
                                    <div class="preview-zone dropzone-preview">
                                        <div class="box box-solid">
                                            <div class="box-body flex items-center gap-2 flex-wrap">

                                                @if (isset($bundle) && fileExists($folder = 'lms/courses/bundles', $fileName = $bundle?->thumbnail) == true && $bundle?->thumbnail !== '')
                                                    <div class="img-thumb-wrapper">
                                                        <button class="remove delete-btn-cs"
                                                            data-action="{{ route('bundle.thumbnail.delete', $bundle->id) }}"
                                                            data-title="Do you want to delete"><i
                                                                class="ri-close-line text-inherit text-[13px]"></i>
                                                        </button>
                                                        <img class="img-thumb" width="100"
                                                            src="{{ asset('storage/lms/courses/bundles/' . $bundle->thumbnail) }}" />
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}


                                <div class="leading-none mt-6">
                                    <label for="courseLevel" class="form-label">
                                        {{ translate('Courses level') }}
                                        <span class="text-danger"
                                            title="{{ translate('This field is required') }}"><b>*</b></span>
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

                                @if (!$isOrganization)
                                    <div class="leading-none mt-6">
                                        <label for="courseInstructor" class="form-label">
                                            {{ translate('Organization') }} </label>
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
                                            <span class="text-danger"
                                                title="{{ translate('This field is required') }}"><b>*</b></span>
                                        </label>
                                        <select class="js-example-basic-single" name="instructors[]"
                                            id="instructorOption" multiple>
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
                            </div>
                        @endif

                        <div class="card col-span-full">
                            <label class="form-label">{{ translate('Description') }}</label>
                            <textarea name="details" class="form-input summernote">{!! clean($translations['details'] ?? ($bundle->details ?? '')) !!}</textarea>
                        </div>
                    </div>
                    <div class="card flex-center justify-end">
                        <button type="submit"
                            class="btn b-solid btn-primary-solid dk-theme-card-square">{{ translate('Submit') }}</button>
                    </div>
                </form>
            </div>
            <div class="fieldset">
                <form action="{{ $action ?? '#' }}" method="POST" data-key="media">
                    @csrf
                    <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">
                    <div class="grid grid-cols-12 gap-x-4">
                        <div class="col-span-full lg:col-span-7 card">
                            @php
                                $src_type = $course->video_src_type ?? null;
                            @endphp
                            <div class="leading-none mt-6">
                                <label class="form-label">
                                    {{ translate('Bundle Demo Video') }}
                                    <span class="text-danger"
                                        title="{{ translate('This field is required') }}"><b>*</b></span>
                                </label>
                                <select class="singleSelect" name="video_src_type" id="source-type-select">
                                    <option disabled selected>{{ translate('Select Source Type') }}</option>
                                    <option value="youtube" {{ $src_type == 'youtube' ? 'selected' : '' }}>
                                        {{ translate('Youtube') }}</option>
                                    <option value="vimeo" {{ $src_type == 'vimeo' ? 'selected' : '' }}>
                                        {{ translate('Vimeo') }}
                                    </option>
                                    <option value="local" {{ $src_type == 'local' ? 'selected' : '' }}>
                                        {{ translate('Local') }}
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
                                        <input type="url" class="form-input"
                                            placeholder="{{ translate('Video url') }}"
                                            value="{{ $course->demo_url ?? '' }}" name="demo_url"
                                            autocomplete="off" />
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
                        </div>
                        <div class="col-span-full lg:col-span-5 card">
                            <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                                {{ translate('Thumbnail') }}({{ translate('300') }}x{{ translate('300') }})
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </p>
                            <label for="thumbnail-one"
                                class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                <input type="file" hidden name="thumbnail" id="thumbnail-one"
                                    class="dropzone dropzone-image img-src peer/file">

                                <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                    <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}" alt="file-icon"
                                        class="size-8 lg:size-auto">
                                    <div class="text-gray-500 dark:text-dark-text mt-2">
                                        {{ translate('Choose file') }} </div>
                                </span>
                            </label>
                            <div class="preview-zone dropzone-preview">
                                <div class="box box-solid">
                                    <div class="box-body flex items-center gap-2 flex-wrap">

                                        @if (isset($course) &&
                                                fileExists($folder = 'lms/courses/thumbnails', $fileName = $course?->thumbnail) == true &&
                                                $course?->thumbnail !== '')
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
                    </div>
                    <div class="card flex-center gap-4 justify-end">
                        <button type="button" class="prev-form-btn btn b-outline btn-primary-outline">
                            {{ translate('Previous') }}
                        </button>
                        <button type="button"
                            class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                            {{ translate('Save & Continue') }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="fieldset">
                <form action="{{ $action ?? '#' }}" method="POST" data-key="price">
                    @csrf
                    <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">

                    <div class="grid grid-cols-12 gap-4 card">
                        <div class="col-span-full lg:col-span-2">
                            <div class="mt-6">
                                <label for="currency" class="form-label">{{ translate('Currency') }}
                                    <span class="text-danger"
                                        title="{{ translate('This field is required') }}"><b>*</b></span>
                                </label>
                                <select data-select id="currency" name="currency" class="singleSelect">
                                    <option selected disabled data-display="{{ translate('Select Currency') }}">
                                        {{ translate('Select Currency') }} </option>
                                    @foreach (all_currency() as $currency)
                                        @php
                                            $codeSymbol = $currency->code . '-' . $currency->symbol;
                                        @endphp
                                        <option value="{{ $currency->code . '-' . $currency->symbol }}"
                                            {{ isset($bundle) && $bundle?->currency == $codeSymbol ? 'selected' : '' }}>
                                            {{ $currency->symbol }} - {{ $currency->code }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text currency_err"></span>
                            </div>
                        </div>

                        <div class="col-span-full lg:col-span-3">
                            <div class="mt-6">
                                <label for="price" class="form-label"> {{ translate('Price') }}
                                    <span class="text-danger"
                                        title="{{ translate('This field is required') }}"><b>*</b></span>
                                </label>
                                <input type="number" placeholder="{{ translate('Your Price') }}"
                                    class="form-input bundle-price-cal" value="{{ $bundlePrice ?? '' }}"
                                    id="price">

                            </div>
                        </div>
                        <div class="col-span-full lg:col-span-3">
                            <div class="mt-6">
                                <label for="platform_fee" class="form-label">
                                    {{ translate('Platform Price') }}
                                    <span class="text-danger"
                                        title="{{ translate('This field is required') }}"><b>*</b></span>
                                </label>

                                <input type="hidden"value="{{ $platformFee ?? '' }}" name="platform_fee">
                                <input type="number" id="platform_fee"
                                    placeholder="{{ translate('Platform Price') }}" disabled
                                    class="form-input disabled:!text-heading" value="{{ $platformFee ?? '' }}"
                                    placeholder="Platform Price">
                                <span class="text-danger error-text title_err"></span>

                            </div>
                        </div>
                        <div class="col-span-full lg:col-span-3">
                            <div class="mt-6">
                                <label for="total_price" class="form-label">{{ translate('Total Price') }}
                                    <span class="text-danger"
                                        title="{{ translate('This field is required') }}"><b>*</b></span>
                                </label>
                                <input type="number" id="total_price" placeholder="{{ translate('Bundle Price') }}"
                                    name="price" class="form-input"
                                    value="{{ $bundlePrice + $platformFee ?? '' }}">
                                <span class="text-danger error-text  price_err"></span>
                            </div>

                        </div>
                    </div>
                    <div class="card flex-center gap-4 justify-end">
                        <button type="button" class="prev-form-btn btn b-outline btn-primary-outline">
                            {{ translate('Previous') }}
                        </button>
                        <button type="button"
                            class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                            {{ translate('Save & Continue') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="fieldset">
                <form action="{{ $action ?? '#' }}" method="POST" data-key="course">
                    @csrf
                    <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">
                    <div class="grid grid-cols-12 gap-4 card">
                        <div class="col-span-full mt-6">
                            <label for="coupon-type" class="form-label">
                                {{ translate('Select Course') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <select class="multipleSelect form-input" multiple="multiple" name="courseId[]">
                                @foreach (get_all_course() as $course)
                                    @php $courseTranslations = parse_translation($course, $locale); @endphp
                                    <option value="{{ $course->id }}"
                                        @if (isset($bundle) && $bundle?->courses?->count() > 0) @foreach ($bundle?->courses as $bcourse)
                                        {{ $bcourse->id == $course->id ? 'selected' : '' }}
                                    @endforeach @endif>
                                        {{ $courseTranslations['title'] ?? ($course->title ?? '') }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text courseId_err"></span>
                        </div>
                    </div>
                    <div class="card flex-center gap-4 justify-end">
                        <button type="button" class="prev-form-btn btn b-outline btn-primary-outline">
                            {{ translate('Previous') }}
                        </button>
                        <button type="button"
                            class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                            {{ translate('Save & Continue') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="fieldset !block">
                <form action="{{ $action ?? '#' }}" method="POST" data-key="course">
                    @csrf
                    <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">
                    <div class="grid grid-cols-12 gap-4 card">
                        <div class="col-span-full mt-6">
                            <label for="coupon-type" class="form-label">
                                {{ translate('Select Course') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <select class="multipleSelect form-input" multiple="multiple" name="courseId[]">
                                @foreach (get_all_course() as $course)
                                    @php $courseTranslations = parse_translation($course, $locale); @endphp
                                    <option value="{{ $course->id }}"
                                        @if (isset($bundle) && $bundle?->courses?->count() > 0) @foreach ($bundle?->courses as $bcourse)
                                        {{ $bcourse->id == $course->id ? 'selected' : '' }}
                                    @endforeach @endif>
                                        {{ $courseTranslations['title'] ?? ($course->title ?? '') }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text courseId_err"></span>
                        </div>
                    </div>
                    <div class="card flex-center gap-4 justify-end">
                        <button type="button" class="prev-form-btn btn b-outline btn-primary-outline">
                            {{ translate('Previous') }}
                        </button>
                        <button type="button"
                            class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                            {{ translate('Save & Continue') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Start Info -->
            <div class="fieldset">
                <form action="{{ $action ?? '#' }}" method="POST" data-key="additional_information">
                    @csrf
                    <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">
                    <!-- COURSE FAQ -->
                    <div class="card">
                        <div class="grid grid-cols-12 gap-y-5 faq-item">
                            <div class="col-span-full">
                                <div class="flex-center-between">
                                    <h6 class="leading-none text-xl font-semibold text-heading">
                                        {{ translate('Add Course FAQ') }}
                                    </h6>
                                    <button type="button" class="btn b-solid btn-primary-solid add-faq">
                                        <i class="ri-add-circle-line text-inherit"></i> {{ translate('Add') }}
                                    </button>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <div class="flex flex-col gap-5 faq-area"
                                    data-length="{{ isset($course, $course->courseFaqs) ? $course->courseFaqs->count() : 0 }}">
                                    @if (isset($course, $course->courseFaqs) && !empty($course->courseFaqs))
                                        @foreach ($course->courseFaqs as $courseFaq)
                                            <div class="flex gap-4">
                                                <div class="grow flex flex-col gap-2">
                                                    <input type="hidden" name="faqs[{{ $courseFaq->id }}][id]"
                                                        class="form-input" value="{{ $courseFaq->id }}">

                                                    <input type="text"
                                                        placeholder="{{ translate('Faq question') }}"name="faqs[{{ $courseFaq->id }}][title]"
                                                        class="form-input" value="{{ $courseFaq->title }}">
                                                    <textarea name="faqs[{{ $courseFaq->id }}][answer]" placeholder="{{ translate('Faq Answer') }}"
                                                        class="form-input">{{ $courseFaq->answer }}</textarea>
                                                </div>
                                                <button type="button"
                                                    class="btn-icon btn-danger-icon-light shrink-0 delete-btn"
                                                    data-id="{{ $courseFaq->id }}" data-key="faq">
                                                    <i class="ri-delete-bin-line text-inherit"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- COURSE OUTCOME -->
                    <div class="card">
                        <div class="grid grid-cols-12 gap-y-5 outcome-item">
                            <div class="col-span-full">
                                <div class="flex-center-between">
                                    <h6 class="leading-none text-xl font-semibold text-heading">
                                        {{ translate('Add Course Outcomes') }} </h6>
                                    <button type="button" class="btn b-solid btn-primary-solid add-outcomes"> <i
                                            class="ri-add-circle-line text-inherit"></i> {{ translate('Add') }}
                                    </button>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <div class="flex flex-col gap-5 outcomes-area"
                                    data-length="{{ isset($course, $course->courseOutComes) ? $course->courseOutComes->count() : 0 }}">
                                    @if (isset($course, $course->courseOutComes) && !empty($course->courseOutComes))
                                        @foreach ($course->courseOutComes as $courseOutCome)
                                            <div class="flex gap-4">
                                                <div class="grow flex flex-col gap-2 relative">
                                                    <input type="text"
                                                        placeholder="{{ translate('Course Outcomes') }}"
                                                        id="searchInput"
                                                        name="outcomes[{{ $courseOutCome->id }}][title]"
                                                        class="form-input outcomes search-suggestion"
                                                        value="{{ $courseOutCome->title }}"
                                                        data-search-type="outcomes">

                                                    <div class="search-show"></div>
                                                </div>
                                                <button type="button"
                                                    class="btn-icon btn-danger-icon-light shrink-0 delete-btn">
                                                    <i class="ri-delete-bin-line text-inherit"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- COURSE TAG -->
                    <div class="card">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-full">
                                <div class="flex-center-between">
                                    <h6 class="text-xl font-semibold text-heading"> {{ translate('Course Tag') }}
                                    </h6>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <select class="tag-list" name="tags[]" multiple="multiple">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card flex-center gap-4 justify-end">
                        <button type="button" class="prev-form-btn btn b-outline btn-primary-outline">
                            {{ translate('Previous') }}
                        </button>
                        <button type="button"
                            class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                            {{ translate('Save & Continue') }}
                        </button>
                    </div>
                </form>
            </div>
            <!-- Start Setting -->
            <div class="fieldset">
                <form action="{{ $action ?? '#' }}" method="POST" data-key="setting">
                    @csrf
                    <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">
                    <input type="hidden" name="setting_id" value="{{ $course?->courseSetting?->id ?? null }}">

                    <div class="grid grid-cols-12 gap-x-4">
                        <div class="col-span-full lg:col-span-6 card">
                            <h6 class="text-xl font-semibold text-heading">{{ translate('Course Settings') }}</h6>
                            <div class="mt-10">
                                <div class="leading-none mb-10">
                                    <label for="seat"
                                        class="form-label">{{ translate('Seat Capacity') }}</label>
                                    <input type="number" id="seat"
                                        placeholder="{{ translate('Seat Capacity') }}" name="seat_capacity"
                                        class="form-input"
                                        value="{{ $course?->courseSetting?->seat_capacity ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-span-full lg:col-span-6 card">
                            <h6 class="text-xl font-semibold text-heading">{{ translate('Course Settings Options') }}
                            </h6>
                            <div class="mt-10">
                                <div class="leading-none flex items-center gap-4 mb-10">
                                    <label for="support" class="inline-flex items-center me-5 cursor-pointer">
                                        <input type="checkbox" id="support" name="has_support"
                                            class="appearance-none peer"
                                            {{ isset($course) && $course?->courseSetting?->has_support == 1 ? 'checked' : '' }}>
                                        <div class="switcher switcher-primary-solid"></div>
                                    </label>
                                    <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                                        {{ translate('Has Support') }}</div>
                                </div>
                                <div class="leading-none flex items-center gap-4 mb-10">
                                    <label for="certificate" class="inline-flex items-center me-5 cursor-pointer">
                                        <input type="checkbox" id="certificate" name="is_certificate"
                                            class="appearance-none peer"
                                            {{ isset($course) && $course?->courseSetting?->is_certificate == 1 ? 'checked' : '' }}>
                                        <div class="switcher switcher-primary-solid"></div>
                                    </label>
                                    <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                                        {{ translate('Has Certificate') }}</div>
                                </div>

                                <div class="leading-none flex items-center gap-4 mb-10">
                                    <label for="upcoming" class="inline-flex items-center me-5 cursor-pointer">
                                        <input type="checkbox" id="upcoming" class="appearance-none peer"
                                            name="is_upcoming"
                                            {{ isset($course) && $course?->courseSetting?->is_upcoming == 1 ? 'checked' : '' }}>
                                        <div class="switcher switcher-primary-solid"></div>
                                    </label>
                                    <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                                        {{ translate('Is Upcoming') }}</div>
                                </div>
                                <div class="leading-none flex items-center gap-4 mb-10">
                                    <label for="free" class="inline-flex items-center me-5 cursor-pointer">
                                        <input type="checkbox" id="free" class="appearance-none peer"
                                            name="is_free"
                                            {{ isset($course) && $course?->courseSetting?->is_free == 1 ? 'checked' : '' }}>
                                        <div class="switcher switcher-primary-solid"></div>
                                    </label>
                                    <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                                        {{ translate('Is Free Course') }}</div>
                                </div>
                                <div class="leading-none flex items-center gap-4 mb-10">
                                    <label for="live" class="inline-flex items-center me-5 cursor-pointer">
                                        <input type="checkbox" id="live" class="appearance-none peer"
                                            name="is_live"
                                            {{ isset($course) && $course?->courseSetting?->is_live == 1 ? 'checked' : '' }}>
                                        <div class="switcher switcher-primary-solid"></div>
                                    </label>
                                    <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                                        {{ translate('Is Live') }}</div>
                                </div>

                                <div class="leading-none flex items-center gap-4 mb-10">
                                    <label for="is_subscribe" class="inline-flex items-center me-5 cursor-pointer">
                                        <input type="checkbox" id="is_subscribe" class="appearance-none peer"
                                            name="is_subscribe"
                                            {{ isset($course) && $course?->courseSetting?->is_subscribe == 1 ? 'checked' : '' }}>
                                        <div class="switcher switcher-primary-solid"></div>
                                    </label>
                                    <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                                        {{ translate('Subscribe') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card flex-center gap-4 justify-end">
                        <button type="button"
                            class="prev-form-btn btn b-outline btn-primary-outline">{{ translate('Previous') }}</button>
                        <button type="button"
                            class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">{{ translate('Save & Continue') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @push('js')
            <script>
                $('.multipleSelect').select2({
                    placeholder: "{{ translate('Select Courses') }}",
                    width: "100%"
                })

                $('#courseCategory').select2({
                    placeholder: "{{ translate('Select Courses') }}",
                    width: "100%"
                })

                $('#courseLevel').select2({
                    placeholder: "{{ translate('Select Courses') }}",
                    width: "100%"
                })

                $('#instructorOption').select2({
                    placeholder: "{{ translate('Select Courses') }}",
                    width: "100%"
                })
            </script>
        @endpush
</x-dashboard-layout>
