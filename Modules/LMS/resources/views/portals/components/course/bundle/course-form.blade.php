@php
    $locale = app()->getLocale();
    $courses = $courses ?? [];
@endphp
<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="courses">
        @csrf
        <input type="hidden" name="bundle_id" class="Id" value="{{ $bundle->id ?? '' }}">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6 card">
                <h6 class="text-xl font-semibold text-heading">{{ translate('Bundle') }}</h6>
                <select class="multipleSelect form-input" multiple="multiple" name="courseId[]">
                    @foreach ($courses as $course)
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

            @if (module_enable_check('subscribe') || module_enable_check('certificate'))
                <div class="col-span-full lg:col-span-6 card">
                    <h6 class="text-xl font-semibold text-heading">{{ translate('Bundle Settings Options') }}
                    </h6>
                    <div class="mt-10">

                        @if (module_enable_check('subscribe'))
                            <div class="leading-none flex items-center gap-4 mb-10">
                                <label for="subscribe" class="inline-flex items-center me-5 cursor-pointer">
                                    <input type="checkbox" id="subscribe" name="is_subscribe"
                                        class="appearance-none peer"
                                        {{ isset($bundle) && $bundle?->is_subscribe == 1 ? 'checked' : '' }}>
                                    <div class="switcher switcher-primary-solid"></div>
                                </label>
                                <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                                    {{ translate('Subscribe') }}</div>
                            </div>
                        @endif

                        @if (module_enable_check('certificate'))
                            <div class="leading-none flex items-center gap-4 mb-10">
                                <label for="certificate" class="inline-flex items-center me-5 cursor-pointer">
                                    <input type="checkbox" id="certificate" name="is_certificate"
                                        class="appearance-none peer"
                                        {{ isset($bundle) && $bundle?->is_certificate == 1 ? 'checked' : '' }}>
                                    <div class="switcher switcher-primary-solid"></div>
                                </label>
                                <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                                    {{ translate('Has Certificate') }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
        <div class="card flex-center gap-4 justify-end">
            <button type="button"
                class="prev-form-btn btn b-outline btn-primary-outline">{{ translate('Previous') }}</button>
            <button type="button"
                class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">{{ translate('Save & Continue') }}
            </button>
        </div>
    </form>
</div>
