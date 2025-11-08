@php
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    $bundle = $bundle ?? null;
    if ($bundle && $locale) {
        $translations = parse_translation($bundle, $locale);
    }
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ translate('View Bundle') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('bundle.index') }}"
        title="{{ translate('View') }} {{ translate('Bundle') }}" page-to="Bundle" />
    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-full lg:col-span-6 card">
            <h6 class="leading-none text-xl font-semibold text-heading">
                {{ translate('View') }}
            </h6>
            <div class="mt-7">
                <div class="mt-6">
                    <label for="bundle-title" class="form-label">
                        {{ translate('Title') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" id="bundle-title" placeholder="{{ translate('Title') }}" class="form-input"
                        name="title" value="{{  $translations['title'] ?? $bundle->title ?? '' }}">
                    <span class="text-danger error-text title_err"></span>
                </div>
                <div class="mt-6">
                    <label for="bundle-price" class="form-label">
                        {{ translate('Price') }}($)
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="number" id="bundle-price" placeholder="{{ translate('Bundle Price') }}"
                        name="price" class="form-input" value="{{ $bundle->price ?? '' }}">
                    <span class="text-danger error-text title_err"></span>
                </div>
                <div class="mt-6">
                    <label for="coupon-type" class="form-label">
                        {{ translate('Select Course') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select class="multipleSelect form-input" multiple="multiple" name="courseId[]">
                        @foreach (get_all_course() as $course)
                            @php $courseTranslations = parse_translation($course, $locale); @endphp
                            <option value="{{ $course->id }}"
                                @if (isset($bundle) && $bundle?->courses?->count() > 0) @foreach ($bundle?->courses as $bcourse)
                                           {{ $bcourse->id == $course->id ? 'selected' : '' }}
                                      @endforeach @endif>
                                {{ $courseTranslations['title'] ?? $course->title }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text courseId_err"></span>
                </div>
            </div>
        </div>
        <div class="col-span-full lg:col-span-6 card">
            <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Media') }}</h6>
            <div class="mt-7">
                <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                    {{ translate('Thumbnail') }}({{ translate('300') }}x{{ translate('300') }})</p>
                <div class="preview-zone dropzone-preview">
                    <div class="box box-solid">
                        <div class="box-body flex items-center gap-2 flex-wrap">
                            @if (isset($bundle) &&
                                    fileExists($folder = 'lms/courses/bundles', $fileName = $bundle?->thumbnail) == true &&
                                    $bundle?->thumbnail !== '')
                                <div class="img-thumb-wrapper">
                                    <img class="img-thumb" width="100"
                                        src="{{ asset('storage/lms/courses/bundles/' . $bundle->thumbnail) }}" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-span-full">
            <label class="form-label">{{ translate('Description') }}</label>
            <div>
                {!! clean( $translations['details'] ?? $bundle->details ?? '') !!}
            </div>
        </div>
    </div>
</x-dashboard-layout>
