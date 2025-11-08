<!-- Notice Board -->
<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="noticeboard">
        @csrf
        <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6 card p-3 sm:p-6">
                <h6 class="text-xl font-semibold text-heading">{{ translate('Notice Board') }}</h6>
                <div class="mt-7">
                    <label for="notice-title" class="form-label">{{ translate('Title') }}</label>
                    <input type="text" id="notice-title" class="form-input" placeholder="{{ translate('Title') }}"
                        name="notice_title" autocomplete="off" />
                    <span class="text-danger error-text notice_title_err"></span>
                </div>
                <div class="mt-4">
                    <label class="form-label">{{ translate('Notice Description') }}</label>
                    <textarea class="summernote form-input" name="notice_description"></textarea>
                    <span class="text-danger error-text notice_description_err"></span>
                </div>
                <div class="flex items-center gap-2 peer/discount mt-10">
                    <input id="is-mailable" type="checkbox" name="is_mailable" class="check check-primary-solid">
                    <label for="is-mailable" class="form-label !m-0">
                        {{ translate('Do you want to mail this notice to all of your students?') }}
                    </label>
                </div>
            </div>
            <div class="col-span-full lg:col-span-6 card p-3 sm:p-6 relative">
                <h6 class="text-xl font-semibold text-heading">{{ translate('All Notice') }}</h6>
                @if (isset($course, $course->courseNotes) && $course->courseNotes->count() > 0)
                    <ul class="space-y-5 mt-7">
                        @foreach ($course->courseNotes as $courseNote)
                            <li class="text-gray-500 dark:text-dark-text">{{ $courseNote->title }}</li>
                        @endforeach
                    </ul>
                @else
                    <li class="position-center text-gray-500 dark:text-dark-text">
                        {{ translate('No Notice Available.') }}</li>
                @endif
            </div>
        </div>

        <div class="card flex-center gap-4 justify-end">
            <button type="button" class="prev-form-btn btn b-outline btn-primary-outline">
                {{ translate('Previous') }}
            </button>
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }}
            </button>
        </div>
    </form>
</div>
