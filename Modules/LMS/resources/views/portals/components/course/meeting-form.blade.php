<!-- Course Meeting Provider -->
<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="meet-provider">
        @csrf
        <input type="hidden" name="course_id" value="{{ $course->id ?? '' }}">

        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6 card">
                <h6 class="text-xl font-semibold text-heading"> {{ translate('Manage Meeting') }} </h6>
                <div class="mt-8">
                    <label for="courseCategory" class="form-label"> {{ translate('Meeting Provider') }} </label>
                    <select class="singleSelect" name="meet_provider_id">
                        <option selected disabled> {{ translate('Select meeting provider') }} </option>
                        @foreach (get_all_mprovider() as $mprovider)
                            <option value="{{ $mprovider->id }}"
                                {{ isset($course) && $course?->meetProvider?->meet_provider_id == $mprovider->id ? 'selected' : '' }}>
                                {{ $mprovider->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <label for="meeting-id" class="form-label"> {{ translate('Meeting Id') }} </label>
                    <input type="text" id="meeting-id" placeholder="{{ translate('Enter Meeting Id') }}"
                        name="meeting_id" class="form-input" value="{{ $course?->meetProvider?->meeting_id ?? '' }}">
                </div>
                <div class="mt-4">
                    <label for="maderator-password" class="form-label"> {{ translate('Moderator password') }} </label>
                    <div class="relative">
                        <input type="password" id="maderator-password" name="moderator_pw"
                            placeholder="{{ translate('Enter Moderator Password') }}" class="form-input"
                            value="{{ $course?->meetProvider?->moderator_pw ?? '' }}">
                        <label for="toggleInputType"
                            class="size-8 rounded-md flex-center hover:bg-gray-200 focus:bg-gray-200 position-center left-[calc(100%_-_23px)]">
                            <input type="checkbox" id="toggleInputType" class="inputTypeToggle peer/it" hidden> <i
                                class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-span-full lg:col-span-6 card">
                <h6 class="text-xl font-semibold text-heading"> {{ translate('Set Meeting Time') }} </h6>
                <div class="mt-8">
                    <div class="mt-4">
                        <label class="form-label"> {{ translate('Schedule Date') }} </label>
                        <input type="text" class="form-input" id="scheduleDate" name="class_schedule_date"
                            placeholder="{{ translate('Please select Date') }}"
                            value="{{ $course?->meetProvider?->class_schedule_date ?? '' }}">
                    </div>
                    <div class="mt-4">
                        <label class="form-label">{{ translate('Schedule Time') }}</label>
                        <input type="text" class="form-input" name="class_schedule_time" id="scheduleTime"
                            placeholder="{{ translate('Please select Time') }}"
                            value="{{ $course?->meetProvider?->class_schedule_time ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h6 class="text-xl font-semibold text-heading">
                {{ translate('Instruction for students') }}
            </h6>
            <div class="mt-5">
                <textarea class="summernote" name="instruction">{!! clean($course?->meetProvider?->instruction ?? '') !!}</textarea>
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
