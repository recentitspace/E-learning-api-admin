@php
    $locale = request()->locale ?? app()->getLocale();
    $storeRoute = 'bundle.store';
    $updateRoute = 'bundle.update';
    $thumbnailRemove = 'bundle.thumbnail.delete';
    $translate = 'bundle.translate';
    if (isInstructor()) {
        $storeRoute = 'instructor.bundle.store';
        $updateRoute = 'instructor.bundle.update';
        $thumbnailRemove = 'instructor.bundle.thumbnail.delete';
        $translate = 'instructor.bundle.translate';
    } elseif (isOrganization()) {
        $storeRoute = 'organization.bundle.store';
        $updateRoute = 'organization.bundle.update';
        $thumbnailRemove = 'organization.bundle.thumbnail.delete';
        $translate = 'organization.bundle.translate';
    }

    $translations = [];
    $bundle = $bundle ?? null;
    if ($bundle && $locale) {
        $translations = parse_translation($bundle, $locale);
    }

    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $platformFee = $backendSetting['platform_fee'] ?? 0;
    $bundlePrice = isset($bundle) ? $bundle->price - $bundle->platform_fee : null;

@endphp


@if (is_active($translate) === 'active')
    <div class="flex items-center justify-end gap-4 mb-2">
        <h2 class="card-title">{{ translate('Translate Language') }}</h2>
        <form method="GET" class="sm:block" id="change-translate-language">
            <select onchange="window.location.href=this.options[this.selectedIndex].value" name="id"
                class="text-gray-500 dark:text-dark-text dark:bg-dark-card-shade font-semibold bg-white focus:outline-none cursor-pointer select-none text-sm border dk-border-one px-2 py-2 rounded-md dk-theme-card-square">
                @foreach (app('languages') as $lang)
                    <option value="{{ $lang->code }}" {{ isset($locale) && $locale == $lang->code ? 'selected' : '' }}>
                        {{ $lang->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
@endif
<form action="{{ isset($bundle) ? route($updateRoute, $bundle->id) : route($storeRoute) }}" class="mb-4 form"
    method="POST" enctype="multipart/form-data">
    @if (isset($bundle))
        @method('PUT')
        <input type="hidden" id="id" value="{{ $bundle->id }}">
    @endif
    <input type="hidden" name="user_id" value="{{ authCheck()->id ?? '' }}">
    @csrf
    <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-full {{ is_active($translate) !== 'active' ? 'lg:col-span-6' : '' }} card">
            <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Bundle Info') }}</h6>
            <div class="mt-7">
                <div class="mt-4">
                    <label for="bundle-title" class="form-label"> {{ translate('Title') }} <span class="text-danger"> *
                        </span> </label>
                    <input type="text" id="bundle-title" placeholder="{{ translate('Title') }}" class="form-input"
                        name="title" value="{{ $translations['title'] ?? ($bundle->title ?? '') }}">
                    <span class="text-danger error-text title_err"></span>
                </div>
                @if (is_active($translate) == 'active')
                    <input type="hidden" id="bundle-price" name="price" class="form-input"
                        value="{{ isset($bundle) ? $bundle->price : '' }}">
                @endif
                @if (is_active($translate) !== 'active')
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-full lg:col-span-3">
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
                        <div class="col-span-full lg:col-span-4">
                            <div class="mt-6">
                                <label for="price" class="form-label"> {{ translate('Price') }} <span
                                        class="text-danger"
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
                                <input type="number" id="platform_fee" placeholder="{{ translate('Platform Fee') }}"
                                    disabled class="form-input disabled:!text-heading" value="{{ $platformFee ?? '' }}"
                                    placeholder="Platform Price">
                                <span class="text-danger error-text title_err"></span>

                            </div>
                        </div>
                        <div class="col-span-full lg:col-span-2">
                            <div class="mt-6">
                                <label for="total_price" class="form-label">{{ translate('Total Price') }}
                                    <span class="text-danger"
                                        title="{{ translate('This field is required') }}"><b>*</b></span>
                                </label>
                                <input type="number" id="total_price" placeholder="{{ translate('Bundle Price') }}"
                                    name="price" class="form-input" value="{{ $bundlePrice + $platformFee ?? '' }}">
                                <span class="text-danger error-text  price_err"></span>
                            </div>

                        </div>
                    </div>
                @endif
                <div class="mt-4">
                    <label for="coupon-type" class="form-label">{{ translate('Select courses') }} <span
                            class="text-danger"> *</span> </label>
                    @if (!isOrganization())
                        <select class="multipleSelect form-input" multiple="multiple" name="courseId[]">
                            @foreach (get_course_by_instructorId(authCheck()->id) as $course)
                                @php
                                    $courseTranslationsData = parse_translation($course);
                                @endphp
                                <option value="{{ $course->id }}"
                                    @if (isset($bundle) && $bundle?->courses?->count() > 0) @foreach ($bundle?->courses as $bcourse)
                                   {{ $bcourse->id == $course->id ? 'selected' : '' }}
                              @endforeach @endif>
                                    {{ $courseTranslationsData['title'] ?? $course->title }}</option>
                            @endforeach
                        </select>
                    @else
                        <select class="multipleSelect form-input" multiple="multiple" name="courseId[]">
                            @foreach (getOrganizationCourse() as $course)
                                @php
                                    $courseTranslations = parse_translation($course);
                                @endphp
                                <option value="{{ $course->id }}"
                                    @if (isset($bundle) && $bundle?->courses?->count() > 0) @foreach ($bundle?->courses as $bcourse)
                                       {{ $bcourse->id == $course->id ? 'selected' : '' }}
                                  @endforeach @endif>
                                    {{ $courseTranslations['title'] ?? $course->title }}</option>
                            @endforeach
                        </select>
                    @endif
                    <span class="text-danger error-text courseId_err"></span>
                </div>
                <div class="mt-4">
                    <label class="form-label">{{ translate('Description') }}</label>
                    <textarea name="details" class="form-input summernote">{!! clean($translations['details'] ?? ($bundle->details ?? '')) !!}</textarea>
                </div>
            </div>
        </div>
        @if (is_active($translate) !== 'active')
            <div class="col-span-full lg:col-span-6 card">
                <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Media') }}</h6>
                <div class="mt-7">
                    <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                        {{ translate('Thumbnail') }}( 300 x 300 )
                    </p>
                    <label for="thumbnail-one"
                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                        <input type="file" hidden name="image" id="thumbnail-one"
                            class="dropzone dropzone-image img-src peer/file">

                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                            <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}" alt="file-icon"
                                class="size-8 lg:size-auto">
                            <div class="text-gray-500 dark:text-dark-text mt-2">{{ translate('Choose file') }}</div>
                        </span>
                    </label>
                    <div class="preview-zone dropzone-preview">
                        <div class="box box-solid">
                            <div class="box-body flex items-center gap-2 flex-wrap">

                                @if (isset($bundle) && fileExists('lms/courses/bundles', $bundle?->thumbnail) == true && $bundle?->thumbnail !== '')
                                    <div class="img-thumb-wrapper"> <button class="remove delete-btn-cs"
                                            data-action="{{ route($thumbnailRemove, $bundle->id) }}"
                                            data-title="{{ translate('Do you want to delete') }}"><i
                                                class="ri-close-line text-inherit text-[13px]"></i>
                                        </button>
                                        <img class="img-thumb" width="100"
                                            src="{{ asset('storage/lms/courses/bundles/' . $bundle->thumbnail) }}" />
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    <div class="card flex-center justify-end">
        <button type="submit" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
            {{ isset($bundle) ? translate('Update') : translate('Save') }}
        </button>
    </div>
</form>
@push('js')
    <script>
        $('.multipleSelect').select2({
            placeholder: "{{ translate('Select Courses') }}",
            width: "100%"
        })
    </script>
@endpush
