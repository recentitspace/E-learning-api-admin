@php
    $locale = request()->locale ?? app()->getLocale();
    $isOrganization = isOrganization();
    $isAdmin = isAdmin();
    $isInstructor = isInstructor();
    $currentUser = authCheck();
    $type = $type ?? '';

    $translations = [];
    $bundle = $bundle ?? null;
    if ($bundle && $locale) {
        $translations = parse_translation($bundle, $locale);
    }
@endphp
<div class="fieldset !block">
    <form action="{{ $action ?? '#' }}" class="mb-4 form" method="POST" data-key="basic">
        @csrf
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <input type="hidden" name="bundle_id" class="form-input" value="{{ $bundle->id ?? '' }}">
        @if ($isInstructor)
            <input type="hidden" name="instructor_id" class="form-input" value="{{ $currentUser->id ?? '' }}">
        @endif
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6 card">
                <div class="mt-7">
                    <div class="mt-6">
                        <label for="bundle-title" class="form-label"> {{ translate('Title') }}
                            <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                        </label>
                        <input type="text" id="bundle-title" placeholder="{{ translate('Title') }}"
                            class="form-input" name="title"
                            value="{{ $translations['title'] ?? ($bundle->title ?? '') }}">
                        <span class="text-danger error-text title_err"></span>
                    </div>
                </div>

                <div class="leading-none mt-6">
                    <label for="courseCategory" class="form-label">
                        {{ translate('Category') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select name="category_id" id="courseCategory"
                        class="list-border-primary px-5 py-[17.5px] wide leading-none border border-input-border rounded-10 text-gray-900 font-spline_sans [&.open]:border-primary-400">
                        <option></option>
                        @foreach (get_all_category() as $category)
                            @php
                                $categoryTranslations = parse_translation($category, $locale);
                            @endphp
                            <option value="{{ $category->id }}"
                                {{ isset($bundle) && $bundle->category_id == $category->id ? 'selected' : '' }}>
                                {{ $categoryTranslations['title'] ?? ($category->title ?? '') }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text category_id_err"></span>
                </div>
            </div>

            <div class="col-span-full lg:col-span-6 card">
                <div class="leading-none mt-6">
                    <label for="bundleLevel" class="form-label">
                        {{ translate('Bundle level') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select name="levels[]" multiple="true" id="bundleLevel"
                        class="level-list list-border-primary px-5 py-[17.5px] wide leading-none border border-input-border rounded-10 text-gray-900 font-spline_sans [&.open]:border-primary-400">
                        @foreach (get_all_level(locale: $locale) as $level)
                            @php
                                $levelTranslations = parse_translation($level, $locale);
                            @endphp
                            <option value="{{ $level->id }}"
                                @if (isset($bundle, $bundle->levels) && !empty($bundle->levels)) @foreach ($bundle->levels as $bLevel)
                                                {{ $bLevel->id == $level->id ? 'selected' : '' }}
                                     @endforeach @endif>
                                {{ $levelTranslations['name'] ?? ($level->name ?? '') }}
                            </option>
                        @endforeach
                    </select>

                    <span class="text-danger error-text levels_err"></span>
                </div>

                @if ($isAdmin || $isOrganization)
                    <div class="leading-none mt-6">
                        <label class="form-label">
                            {{ translate('Instructor') }}
                            <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                        </label>
                        <select class="js-example-basic-single" name="instructor_id" id="instructorOption">
                            <option disabled>{{ translate('Select Instructor') }}</option>
                            @foreach (get_all_instructor($currentUser->id ?? null, locale: $locale) as $instructor)
                                @php
                                    $insUser = $instructor?->userable;
                                    $userTranslations = parse_translation($insUser, $locale);
                                @endphp
                                <option value="{{ $instructor->id }}"
                                    {{ isset($bundle) && $bundle->user_id == $instructor->id ? 'selected' : '' }}>
                                    {{ $userTranslations['first_name'] ?? $insUser?->first_name }}
                                    {{ $userTranslations['last_name'] ?? $insUser?->last_name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text instructors_err"></span>
                    </div>
                @endif
            </div>

            <div class="card col-span-full">
                <label class="form-label">{{ translate('Description') }} <span class="text-danger"
                        title="{{ translate('This field is required') }}"><b>*</b></span></label>
                <textarea name="details" class="form-input summernote">
                    {!! clean($translations['details'] ?? ($bundle->details ?? '')) !!}
                </textarea>
                <span class="text-danger error-text details_err"></span>
            </div>
        </div>

        <div class="card flex-center gap-4 justify-end">
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">

                @if ($type == 'translations')
                    {{ translate('Save') }}
                @else
                    {{ !isset($bundle) ? translate('Save') : translate('Save & Continue') }}
                @endif
            </button>
        </div>
    </form>
</div>
