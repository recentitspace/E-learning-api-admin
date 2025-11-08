<form action="{{ $action }}" method="post" class="form" enctype="multipart/form-data">
    @csrf
    <div class="card grid grid-cols-2 gap-x-4 gap-y-6">
        <div class="col-span-full xl:col-auto leading-none">
            <label class="form-label"> {{ translate('Title') }} <span class="text-danger">*</span></label>
            <input type="text" placeholder="{{ translate('Enter your Title') }}" name="title" class="form-input"
                autocomplete="off">
            <span class="text-danger error-text title_err"></span>
        </div>
        <div class="col-span-full xl:col-auto leading-none">
            <label for="noticeType" class="form-label"> {{ translate('Support Type') }} <span
                    class="text-danger">*</span></label>
            <select class="singleSelect support-category-type" name="type" required>
                <option selected disabled> {{ translate('Select Course Type') }} </option>
                <option value="platform"> {{ translate('Platform') }} </option>
                <option value="course"> {{ translate('Course') }} </option>
            </select>
            <span class="text-danger error-text type_err"></span>
        </div>
        <div class="col-span-full xl:col-auto leading-none" id="supportCourse">
            <label for="noticeType" class="form-label"> {{ translate('Course') }} <span
                    class="text-danger">*</span></label>
            <select class="singleSelect" name="course_id" required>
                <option selected disabled> {{ translate('Select Course Type') }} </option>
                @if (isStudent())
                    @foreach (purchase_enrolled_courses() as $purchaseCourse)
                        @php
                            $courseTranslations = parse_translation($purchaseCourse?->course);
                        @endphp
                        <option value="{{ $purchaseCourse?->course?->id }}">
                            {{ $courseTranslations['title'] ?? $purchaseCourse?->course?->title }}</option>
                    @endforeach
                @else
                    @if (isset($courses))
                        @foreach ($courses as $course)
                            @php
                                $courseTranslations = parse_translation($course);
                            @endphp
                            <option value="{{ $course?->id }}">
                                {{ $courseTranslations['title'] ?? $course?->title }}</option>
                        @endforeach
                    @endif
                @endif

            </select>
            <span class="text-danger error-text course_id_err"></span>
        </div>
        <div class="col-span-full xl:col-auto leading-none" id="supportCategory">
            <label for="noticeType" class="form-label"> {{ translate('Support Category') }} <span
                    class="text-danger">*</span></label>
            <select class="singleSelect" name="support_category_id" required>
                <option selected disabled> {{ translate('Select Support Category') }} </option>
                @foreach (supportCategories() as $supportCategory)
                    @php
                        $categoryTranslations = parse_translation($supportCategory);
                    @endphp
                    <option value="{{ $supportCategory?->id }}">
                        {{ $categoryTranslations['name'] ?? $supportCategory?->name }}</option>
                @endforeach
            </select>
            <span class="text-danger error-text support_category_id_err"></span>
        </div>
        <div class="col-span-full">
            <label for="courseType" class="form-label"> {{ translate('Description') }} <span
                    class="text-danger">*</span> </label>
            <textarea class="summernote" name="description"></textarea>
            <span class="text-danger error-text description_err"></span>
        </div>
        <div class="">

            <label for="attatch-support-file"
                class="file-container file-input-label !dk-border-two bg-transparent text-[#727175] h-11 w-max dk-theme-card-square">
                <span
                    class="px-3 rounded-lg rounded-r-none border-r bg-[#EEEEEE] dark:bg-dark-icon border-input-border dark:border-dark-border-four flex-center before:font-remix before:text-xl text-sm before:content-['\f24e'] dark:before:text-dark-text-two dk-theme-card-square"></span>
                <input type="file" name="support_files[]" id="attatch-support-file" class="hidden file-src" multiple>
                <span class="file-name text-sm p-2.5"> {{ translate('No file choose') }} </span>
            </label>
        </div>
    </div>
    <div class="card flex justify-end">
        <button type="submit" class="btn b-solid btn-primary-solid px-5 dk-theme-card-square">
            {{ isset($notice) ? translate('Update') : translate('Save') }}
        </button>
    </div>
</form>
