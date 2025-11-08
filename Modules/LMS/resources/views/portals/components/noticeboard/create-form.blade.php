<form action="{{ $action ?? '#' }}" method="post" class="form">
    @csrf
    @if (isset($notice))
        <input type="hidden" value="{{ $notice->id }}" name="id">
    @endif
    <input type="hidden" value="{{ authCheck()->id }}" name="user_id">
    <div class="card grid grid-cols-2 gap-x-4 gap-y-6">
        <div class="col-span-full xl:col-auto leading-none">
            <label for="noticeTitle" class="form-label"> {{ translate('Notice title') }} <span
                    class="text-danger">*</span></label>
            <input type="text" id="noticeTitle" placeholder="{{ translate('Notice Title') }}" name="title"
                class="form-input" autocomplete="off" value="{{ isset($notice) ? $notice->title : '' }}">
            <span class="text-danger error-text title_err"></span>
        </div>
        <input type="hidden" name="type" value="course">
        <div class="col-span-full xl:col-auto leading-none">
            <label for="noticeType" class="form-label"> {{ translate('Course Name') }} <span
                    class="text-danger">*</span></label>
            <select class="singleSelect" name="course_id" data-minimum-results-for-search="Infinity" required>
                <option selected disabled>{{ translate('Select Course Type') }}</option>
                @if (isset($courses))
                    @foreach ($courses as $noticeCourse)
                        @php
                            $courseTranslations = parse_translation($noticeCourse?->course);
                        @endphp
                        <option value="{{ $noticeCourse->course_id }}"
                            {{ isset($notice) && $notice->course_id == $noticeCourse->course_id ? 'selected' : '' }}>
                            {{ $courseTranslations['title'] ?? $noticeCourse?->course?->title }}</option>
                    @endforeach
                @endif

            </select>
            <span class="text-danger error-text course_id_err"></span>
        </div>
        <div class="col-span-full">
            <label for="courseType" class="form-label"> {{ translate('Message') }} </label>
            <textarea class="summernote" name="message">{!! clean($notice->description ?? '') !!}</textarea>
            <span class="text-danger error-text message_err"></span>
        </div>
    </div>
    <div class="card flex justify-end">
        <button type="submit" class="btn b-solid btn-primary-solid px-5 dk-theme-card-square">
            {{ isset($notice) ? translate('Update') : translate('Save') }}
        </button>
    </div>
</form>
