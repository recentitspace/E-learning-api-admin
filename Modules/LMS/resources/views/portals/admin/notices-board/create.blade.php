<x-dashboard-layout>
    <x-slot:title>{{ translate('Create Notice') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('noticeboard.index') }}" title="Create" page-to="Noticeboard" />
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <form action="{{ route('noticeboard.store') }}" method="post" class="form">
                @csrf
                <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                    <div class="col-span-full xl:col-auto leading-none">
                        <label for="noticeTitle" class="form-label"> {{ translate('Notice title') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" name="title" placeholder="{{ translate('Notice Title') }}"
                            class="form-input" autocomplete="off">
                        <span class="text-danger error-text title_err"></span>
                    </div>
                    <div class="col-span-full xl:col-auto leading-none">
                        <label for="noticeType" class="form-label"> {{ translate('Type') }} <span
                                class="text-danger">*</span></label>
                        <select class="singleSelect" name="type" data-minimum-results-for-search="Infinity">
                            <option selected disabled> {{ translate('Select Type') }} </option>
                            <option value="student"> {{ translate('Students') }} </option>
                            <option value="instructor"> {{ translate('Instructors') }} </option>
                            <option value="student-instructor"> {{ translate('Students and Instructors') }} </option>
                            <option value="organization"> {{ translate('Organization') }} </option>
                        </select>
                        <span class="text-danger error-text type_err"></span>
                    </div>
                    <div class="col-span-full">
                        <label for="courseType" class="form-label"> {{ translate('Message') }} </label>
                        <textarea class="summernote" name="message"></textarea>
                        <span class="text-danger error-text message_err"></span>
                    </div>
                </div>
                <button type="submit" class="btn b-solid btn-primary-solid px-5 cursor-pointer mt-6">
                    {{ translate('Save') }}
                </button>
            </form>
        </div>
    </div>
</x-dashboard-layout>
