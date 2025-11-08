@php

    $isOrganization = $isOrganization ?? false;
    $isInstructor = $isInstructor ?? false;
    $user = authCheck();
@endphp

<div class="card">
    <form method="GET">
        <div class="grid grid-cols-4 gap-4">
            <div class="col-span-full sm:col-span-2 xl:col-auto">
                <label class="form-label">{{ translate('Category') }}</label>
                <select class="singleSelect selectFilterCategory" name="categories[]" multiple="multiple">
                    @foreach (get_all_category(type: 'cat') as $category)
                        @php
                            $categoryTranslations = parse_translation($category);
                        @endphp
                        <option value="{{ $category->id }}"
                            @if (isset(Request()->categories)) @foreach (Request()->categories as $selectCat)
                                {{ $selectCat == $category->id ? 'selected' : '' }}
                             @endforeach @endif>
                            {{ $categoryTranslations['title'] ?? $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-full sm:col-span-2 xl:col-auto">
                <label class="form-label">{{ translate('Sub Category') }}</label>
                <select class="singleSelect selectFilterCategory" name="subcategories[]" multiple="multiple">
                    @foreach (get_all_category(type: 'sub') as $subcategory)
                        @php
                            $subCategoryTranslations = parse_translation($subcategory);
                        @endphp
                        <option value="{{ $subcategory->id }}"
                            @if (isset(Request()->subcategories)) @foreach (Request()->subcategories as $selectCat)
                                {{ $selectCat == $subcategory->id ? 'selected' : '' }}
                             @endforeach @endif>
                            {{ $subCategoryTranslations['title'] ?? $subcategory->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-full sm:col-span-2 xl:col-auto">
                <label class="form-label"> {{ translate('Status') }} </label>
                <select class="singleSelect" name="course_status">
                    @php
                        $courseStatus = Request()->course_status ?? null;
                    @endphp
                    <option selected disabled>{{ translate('Select Status') }}</option>
                    <option value="all" {{ $courseStatus == 'all' ? 'selected' : '' }}>{{ translate('All') }}
                    </option>
                    <option value="Approved"{{ $courseStatus == 'Approved' ? 'selected' : '' }}>
                        {{ translate('Approved') }}</option>
                    <option value="Rejected" {{ $courseStatus == 'Rejected' ? 'selected' : '' }}>
                        {{ translate('Rejected') }}</option>
                    <option value="Pending" {{ $courseStatus == 'Pending' ? 'selected' : '' }}>
                        {{ translate('Pending') }}</option>
                </select>
            </div>
            <div class="col-span-full sm:col-span-2 xl:col-auto">
                @php
                    $courseType = Request()->course_type ?? null;
                @endphp
                <label class="form-label"> {{ translate('Course Type') }} </label>
                <select class="singleSelect" name="course_type">
                    <option selected disabled>{{ translate('Select Type') }}</option>
                    <option value="all" {{ $courseType == 'all' ? 'selected' : '' }}>{{ translate('All') }}
                    </option>
                    <option value="free" {{ $courseType == 'free' ? 'selected' : '' }}>{{ translate('Free') }}
                    </option>
                    <option value="paid" {{ $courseType == 'paid' ? 'selected' : '' }}>{{ translate('Paid') }}
                    </option>
                </select>
            </div>
            @if (!$isOrganization && !$isInstructor)
                <div class="col-span-full sm:col-span-2 xl:col-auto">
                    <label class="form-label"> {{ translate('Organization') }} </label>
                    @php
                        $organizations = Request()->organizations ?? null;
                    @endphp
                    <select class="singleSelect organization-list" name="organizations">
                        <option disabled selected>{{ translate('Select Organization') }}</option>
                        @foreach (get_all_organization() as $organization)
                            @php
                                $orgTranslations = parse_translation($organization?->userable);
                            @endphp
                            <option value="{{ $organization->id }}"
                                {{ $organizations == $organization->id ? 'selected' : '' }}>
                                {{ $orgTranslations['name'] ?? $organization?->userable?->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if (!$isInstructor)
                @php
                    $searchInstructors = Request()->instructors ?? [];
                @endphp
                <div class="col-span-full sm:col-span-2 xl:col-auto">
                    <label class="form-label"> {{ translate('Instructor') }} </label>
                    <select class="instructor-list selectFilterInstructor" id="instructorOption" multiple="true"
                        name="instructors[]">
                        @foreach (get_all_instructor($user->id ?? null) as $instructor)
                            @php
                                $user = $instructor?->userable;
                                $instructorTranslations = parse_translation($user);
                            @endphp
                            <option value="{{ $instructor->id }}"
                                @if ($searchInstructors) @foreach ($searchInstructors as $searchInstructor)
                                {{ $searchInstructor == $instructor->id ? 'selected' : '' }}
                                @endforeach @endif>
                                {{ $instructorTranslations['first_name'] ?? $user?->first_name }}
                                {{ $instructorTranslations['last_name'] ?? $user?->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            @endif
            <div class="flex items-end gap-3">
                <button class="btn b-solid btn-info-solid dk-theme-card-square">
                    {{ translate('Filter') }} </button>
                <a href="{{ Request()->url() }}"
                    class="btn b-solid btn-info-solid dk-theme-card-square">{{ translate('Clear') }}</a>
            </div>
        </div>
    </form>
</div>
