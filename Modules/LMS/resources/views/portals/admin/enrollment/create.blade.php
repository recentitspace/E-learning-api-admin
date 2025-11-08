<x-dashboard-layout>
    <x-slot:title>{{ translate('New Enrolled') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('enrollment.index') }}"
        title=" {{ isset($enrollment) ? 'Edit Enroll' : 'New Enroll' }}" page-to="New Enroll" />
  
    <form action="{{ route('enrollment.store') }}" method="post" class="form">
        @csrf
        @if (isset($enrollment))
            <input type="hidden" value="{{ $enrollment->id }}" name="id">
        @endif
        <div class="grid grid-cols-12 card">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label for="courseTitle" class="form-label"> {{ translate('Student') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select class="form-input singleSelect" name="student_id">
                        <option selected disabled>{{ translate('Select Student') }}</option>
                        @foreach (get_all_student() as $student)
                            @php
                                $studentTranslations = parse_translation($student?->userable);
                            @endphp
                            <option value="{{ $student->id }}"
                                {{ isset($enrollment) && $enrollment->user_id == $student->id ? 'selected' : '' }}>
                                {{ $studentTranslations['first_name'] ?? $student?->userable?->first_name }}
                                {{ $studentTranslations['last_name'] ?? $student?->userable?->last_name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text student_id_err"></span>
                </div>
                <div class="mt-6 leading-none">
                    <label for="code" class="form-label">
                        {{ translate('Select Course') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select class="form-input singleSelect" multiple name="courses[]">
                        @foreach (getCourseByStatus() as $course)
                            @php
                                $courseTranslations = parse_translation($course);
                                $courseType =$course?->courseSetting?->is_free == 0 ? 'Paid' :" Free";
                            @endphp
                            <option value="{{ $course->id }}"
                                {{ isset($enrollment) && $enrollment?->course?->id == $course->id ? 'selected' : '' }}>
                                {{ $courseTranslations['title'] ?? $course?->title  }} {{ '-' .''. $courseType }} </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text courses_err"></span>
                </div>
                <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5 dk-theme-card-square">
                    {{ translate('Enrolled') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
