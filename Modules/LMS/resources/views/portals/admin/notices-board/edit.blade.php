<x-dashboard-layout>
    <x-slot:title>{{ translate('Edit Notice') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('noticeboard.index') }}" title="Edit" page-to="Noticeboard" />
    <div class="card overflow-hidden">
        <div class="overflow-x-auto scrollbar-table">
            <form action="{{ route('noticeboard.store') }}" method="post" class="form">
                @csrf
                @if (isset($notice))
                    <input type="hidden" value="{{ $notice->id }}" name="id">
                @endif
                <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                    <div class="col-span-full xl:col-auto leading-none">
                        <label for="noticeTitle" class="form-label">{{ translate('Notice title') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" id="noticeTitle" placeholder="{{ translate('Notice Title') }}"
                            name="title" class="form-input" autocomplete="off" value="{{ $notice->title ?? '' }}">
                        <span class="text-danger error-text title_err"></span>
                    </div>
                    <div class="col-span-full xl:col-auto leading-none">
                        <label for="noticeType" class="form-label"> {{ translate('Type') }} <span
                                class="text-danger">*</span></label>
                        <select class="singleSelect" name="type" data-minimum-results-for-search="Infinity">
                            <option selected disabled> {{ translate('Select Type') }} </option>
                            <option value="student"
                                {{ isset($notice) && $notice->type == 'student' ? 'selected' : '' }}>
                                {{ translate('Students') }} </option>
                            <option value="instructor"
                                {{ isset($notice) && $notice->type == 'instructor' ? 'selected' : '' }}>
                                {{ translate('Instructors') }}
                            </option>
                            <option value="student-instructor"
                                {{ $notice->type == 'student-instructor' ? 'selected' : '' }}>
                                {{ translate('Students and Instructors') }}
                            </option>
                            <option value="organization"
                                {{ isset($notice) && $notice->type == 'organization' ? 'selected' : '' }}>
                                {{ translate('Organization') }}
                            </option>
                        </select>
                        <span class="text-danger error-text type_err"></span>
                    </div>
                    <div class="col-span-full">
                        <label for="courseType" class="form-label">{{ translate('Message') }}</label>
                        <textarea class="summernote" name="message">{!! clean($notice->description ?? '') !!}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn b-solid btn-primary-solid px-5 cursor-pointer mt-6">
                    {{ isset($notice) ? translate('Update') : translate('Save') }}
                </button>
            </form>
        </div>
    </div>
</x-dashboard-layout>
