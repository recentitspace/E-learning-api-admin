<x-dashboard-layout>
    <x-slot:title>{{ translate('Update Enrollment') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('enrollment.index') }}"
        title="{{ translate('Update Enrollment') }}" page-to="{{ translate('Update Enrollment') }}" />

    <form action="{{ route('enrollment.update', $enrollment->id) }}" method="post" class="form" id="enrollmentForm">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-12 card">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label for="student_id" class="form-label">
                        {{ translate('Student') }}
                    </label>
                    <select class="form-input singleSelect" name="student_id" id="student_id">
                        <option value="">{{ translate('Select Student') }}</option>
                        @foreach (get_all_student() as $student)
                            @php
                                $studentTranslations = parse_translation($student?->userable);
                            @endphp
                            <option value="{{ $student->id }}"
                                {{ $enrollment->student_id == $student->id ? 'selected' : '' }}>
                                {{ $studentTranslations['first_name'] ?? $student?->userable?->first_name ?? '' }}
                                {{ $studentTranslations['last_name'] ?? $student?->userable?->last_name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text student_id_err"></span>
                </div>

                <div class="mt-6 leading-none">
                    <label for="course_id" class="form-label">
                        {{ translate('Course') }}
                    </label>
                    <select class="form-input singleSelect" name="course_id" id="course_id" required>
                        @php
                            $allCourses = get_all_course();
                            $enrollmentCourse = $enrollment->course;
                            $enrollmentCourseTranslations = $enrollmentCourse ? parse_translation($enrollmentCourse) : null;
                        @endphp
                        @if($enrollmentCourse && !$allCourses->contains('id', $enrollment->course_id))
                            <option value="{{ $enrollment->course_id }}" selected>
                                {{ $enrollmentCourseTranslations['title'] ?? $enrollmentCourse->title ?? $enrollment->course_title ?? 'N/A' }}
                            </option>
                        @endif
                        @foreach ($allCourses as $course)
                            @php
                                $courseTranslations = parse_translation($course);
                            @endphp
                            <option value="{{ $course->id }}"
                                {{ $enrollment->course_id == $course->id ? 'selected' : '' }}>
                                {{ $courseTranslations['title'] ?? $course->title ?? 'Untitled Course' }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text course_id_err"></span>
                </div>

                <div class="mt-6 leading-none">
                    <label for="course_title" class="form-label">
                        {{ translate('Course Title') }}
                    </label>
                    <input type="text" 
                        class="form-input" 
                        name="course_title" 
                        id="course_title"
                        value="{{ old('course_title', $enrollment->course_title) }}"
                        placeholder="{{ translate('Enter course title') }}">
                    <span class="text-danger error-text course_title_err"></span>
                </div>

                <div class="mt-6 leading-none">
                    <label for="price" class="form-label">
                        {{ translate('Price') }}
                    </label>
                    <input type="number" 
                        class="form-input" 
                        name="price" 
                        id="price"
                        step="0.01"
                        min="0"
                        value="{{ old('price', $enrollment->price) }}"
                        placeholder="{{ translate('Enter price') }}">
                    <span class="text-danger error-text price_err"></span>
                </div>

                <div class="mt-6 leading-none">
                    <label for="course_status" class="form-label">
                        {{ translate('Course Status') }}
                    </label>
                    <select class="form-input" name="course_status" id="course_status">
                        <option value="processing" {{ $enrollment->course_status == 'processing' ? 'selected' : '' }}>
                            {{ translate('Processing') }}
                        </option>
                        <option value="approved" {{ $enrollment->course_status == 'approved' ? 'selected' : '' }}>
                            {{ translate('Approved') }}
                        </option>
                        <option value="completed" {{ $enrollment->course_status == 'completed' ? 'selected' : '' }}>
                            {{ translate('Completed') }}
                        </option>
                    </select>
                    <span class="text-danger error-text course_status_err"></span>
                </div>

                <div class="mt-6 leading-none">
                    <label for="organization_id" class="form-label">
                        {{ translate('Organization') }} ({{ translate('Optional') }})
                    </label>
                    <input type="number" 
                        class="form-input" 
                        name="organization_id" 
                        id="organization_id"
                        value="{{ old('organization_id', $enrollment->organization_id) }}"
                        placeholder="{{ translate('Enter organization ID') }}">
                    <span class="text-danger error-text organization_id_err"></span>
                </div>

                <div class="flex items-center gap-3 mt-6">
                    <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                        {{ translate('Update Enrollment') }}
                    </button>
                    <a href="{{ route('enrollment.index') }}" class="btn b-solid btn-secondary-solid w-max dk-theme-card-square">
                        {{ translate('Cancel') }}
                    </a>
                </div>
            </div>
        </div>
    </form>

    @push('script')
        <script>
            $(document).ready(function() {
                $('#enrollmentForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    const form = $(this);
                    const submitBtn = form.find('button[type="submit"]');
                    const originalText = submitBtn.html();
                    
                    // Ensure course_id is always set (use current value if select is empty)
                    const courseIdSelect = $('#course_id').val();
                    if (!courseIdSelect || courseIdSelect === '') {
                        // If select is empty, ensure it has the current enrollment course_id
                        const currentCourseId = '{{ $enrollment->course_id }}';
                        if (currentCourseId) {
                            $('#course_id').val(currentCourseId);
                        }
                    }
                    
                    // Disable submit button
                    submitBtn.prop('disabled', true).html('<span class="animate-spin">⏳</span> {{ translate("Updating...") }}');
                    
                    // Clear previous errors
                    $('.error-text').text('');
                    
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize() + '&_method=PUT',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        success: function(data) {
                            if (data.status === 'success') {
                                if (typeof Command !== 'undefined' && Command.toastr) {
                                    Command.toastr['success'](data.message || '{{ translate("Enrollment updated successfully!") }}');
                                } else if (typeof toastr !== 'undefined') {
                                    toastr.success(data.message || '{{ translate("Enrollment updated successfully!") }}');
                                } else {
                                    alert(data.message || '{{ translate("Enrollment updated successfully!") }}');
                                }
                                
                                // Redirect to index page
                                if (data.url) {
                                    setTimeout(function() {
                                        window.location.href = data.url;
                                    }, 1000);
                                } else {
                                    window.location.href = '{{ route("enrollment.index") }}';
                                }
                            } else {
                                submitBtn.prop('disabled', false).html(originalText);
                                
                                if (typeof Command !== 'undefined' && Command.toastr) {
                                    Command.toastr['error'](data.message || '{{ translate("Failed to update enrollment") }}');
                                } else if (typeof toastr !== 'undefined') {
                                    toastr.error(data.message || '{{ translate("Failed to update enrollment") }}');
                                } else {
                                    alert(data.message || '{{ translate("Failed to update enrollment") }}');
                                }
                            }
                        },
                        error: function(xhr) {
                            submitBtn.prop('disabled', false).html(originalText);
                            
                            // Handle validation errors
                            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    $('.' + key + '_err').text(value[0]);
                                });
                            }
                            
                            let errorMessage = '{{ translate("An error occurred") }}';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            if (typeof Command !== 'undefined' && Command.toastr) {
                                Command.toastr['error'](errorMessage);
                            } else if (typeof toastr !== 'undefined') {
                                toastr.error(errorMessage);
                            } else {
                                alert(errorMessage);
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
</x-dashboard-layout>

