<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="curriculum" class="pb-10">
        @csrf
        <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? null }}">
        <div class="card p-3 sm:p-6">
            <div class="flex flex-col md:flex-row md:items-center gap-5 justify-between ">
                <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Add Course Curriculum') }}
                </h6>
                <div class="flex items-center justify-end gap-2">
                    <button type="button" data-modal-target="addCourseChapter" data-modal-toggle="addCourseChapter"
                        class="btn b-light btn-primary-light dark:!bg-dark-icon dark:hover:!bg-primary add-chapter">
                        <i class="ri-add-circle-line text-inherit"></i>
                        <span>{{ translate('Add Chapter') }}</span>
                    </button>
                    <button type="button" data-modal-target="addCourseTopic" data-modal-toggle="addCourseTopic"
                        class="btn b-light btn-primary-light dark:!bg-dark-icon dark:hover:!bg-primary add-topic-form">
                        <i class="ri-add-circle-line text-inherit"></i>
                        <span> {{ translate('Add Topic') }} </span>
                    </button>
                </div>
            </div>
            <x-portal::course.curriculum.chapter-list :course=$course />
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
