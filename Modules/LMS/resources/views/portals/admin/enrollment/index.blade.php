<x-dashboard-layout>
    <x-slot:title>{{ translate('Enrollment/Manage') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Student List" page-to="Enroll" action-route="{{ route('enrollment.create') }}" />

    @if ($enrollments->count() > 0)
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary-500">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Student') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Course') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Instructor') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Price') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Status') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Course Status') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Approve') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Enrolled At') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($enrollments as $enrollment)
                            @php
                                $student = $enrollment->student;
                                $studentInfo = $student?->userable ?? null;
                                $course = $enrollment->course;
                                $instructors = $course?->instructors ?? [];
                                
                                $studentTranslations = parse_translation($studentInfo);
                                $courseTranslations = parse_translation($course);
                            @endphp
                            <tr>
                                <td class="px-2 py-4">
                                    <div class="flex flex-col space-y-1">
                                        <h6 class="text-sm font-semibold">
                                            {{ $studentTranslations['first_name'] ?? $studentInfo?->first_name ?? '' }}
                                            {{ $studentTranslations['last_name'] ?? $studentInfo?->last_name ?? '' }}
                                        </h6>
                                        <span class="text-xs text-gray-500">
                                            {{ $student?->email ?? 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-2 py-4">
                                    @if ($course)
                                        <a href="{{ route('course.edit', $course->id) }}" class="text-primary-500 hover:underline">
                                            {{ str_limit($courseTranslations['title'] ?? $course->title ?? $enrollment->course_title, 30, '...') }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">{{ $enrollment->course_title ?? 'N/A' }}</span>
                                    @endif
                                </td>
                                <td class="px-2 py-4">
                                    @if (isset($instructors) && $instructors->count() > 0)
                                        @foreach ($instructors as $instructor)
                                            @php
                                                $instructorInfo = $instructor?->userable ?? null;
                                                $instructorTranslations = parse_translation($instructorInfo);
                                            @endphp
                                            <span>
                                                {{ $instructorTranslations['first_name'] ?? $instructorInfo?->first_name ?? '' }}
                                                {{ $instructorTranslations['last_name'] ?? $instructorInfo?->last_name ?? '' }}
                                            </span>
                                            @if (!$loop->last)
                                                <span>, </span>
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-2 py-4">
                                    @if ($enrollment->status === 'free')
                                        <span class="badge b-solid badge-success-solid capitalize">
                                            {{ translate('Free') }}
                                        </span>
                                    @else
                                        <span class="font-semibold">
                                            ${{ number_format($enrollment->price ?? 0, 2) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-2 py-4">
                                    @if ($enrollment->status === 'free')
                                        <span class="badge b-solid badge-info-solid capitalize">
                                            {{ translate('Free') }}
                                        </span>
                                    @else
                                        <span class="badge b-solid badge-warning-solid capitalize">
                                            {{ translate('Paid') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-2 py-4">
                                    @if ($enrollment->course_status === 'processing')
                                        <span class="badge b-solid badge-warning-solid capitalize">
                                            {{ translate('Processing') }}
                                        </span>
                                    @elseif ($enrollment->course_status === 'approved')
                                        <span class="badge b-solid badge-success-solid capitalize">
                                            {{ translate('Approved') }}
                                        </span>
                                    @elseif ($enrollment->course_status === 'completed')
                                        <span class="badge b-solid badge-info-solid capitalize">
                                            {{ translate('Completed') }}
                                        </span>
                                    @else
                                        <span class="badge b-solid badge-secondary-solid capitalize">
                                            {{ $enrollment->course_status ?? translate('N/A') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-2 py-4">
                                    <div class="form-check form-switch">
                                        <label class="inline-flex items-center me-5 cursor-pointer">
                                            <input type="checkbox" 
                                                class="hidden appearance-none peer approve-enrollment-switch" 
                                                name="approve" 
                                                data-id="{{ $enrollment->id }}"
                                                data-api-url="{{ url('/api/enrollments/' . $enrollment->id) }}"
                                                {{ $enrollment->course_status === 'approved' ? 'checked' : '' }}>
                                            <span class="switcher switcher-primary-solid"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="px-2 py-4">
                                    <span class="text-sm">
                                        {{ customDateFormate($enrollment->created_at, $format = 'd M Y h:i a') }}
                                    </span>
                                </td>
                                <td class="px-2 py-4">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('enrollment.edit', $enrollment->id) }}"
                                            class="btn-icon btn-warning-icon-light size-8"
                                            title="{{ translate('Edit Enrollment') }}">
                                            <i class="ri-edit-line text-inherit text-base"></i>
                                        </a>
                                        <a href="{{ route('enrollment.show', $enrollment->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8"
                                            title="{{ translate('View Details') }}">
                                            <i class="ri-eye-line text-inherit text-base"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Start Pagination -->
            {{ $enrollments->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="No enrollment" action="{{ route('enrollment.create') }}"
            btnText="Add New" />
    @endif

    @push('script')
        <script>
            $(document).on('click', 'label:has(.approve-enrollment-switch), .switcher', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const label = $(this).closest('label');
                const checkbox = label.find('.approve-enrollment-switch');
                
                if (!checkbox.length || checkbox.prop('disabled')) {
                    return false;
                }
                
                // Get enrollment ID
                const enrollmentId = checkbox.data('id');
                if (!enrollmentId) {
                    console.error('No enrollment ID found');
                    return false;
                }
                
                // Get current state and toggle
                const currentState = checkbox.is(':checked');
                checkbox.prop('checked', !currentState);
                const newState = checkbox.is(':checked');
                
                // Determine course_status based on new state
                const courseStatus = newState ? 'approved' : 'processing';
                
                // Build API URL
                const apiUrl = '{{ url("/api/enrollments") }}/' + enrollmentId;
                
                // Disable checkbox during request
                checkbox.prop('disabled', true);
                
                // Call API to update course_status
                $.ajax({
                    url: apiUrl,
                    method: 'PUT',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        course_status: courseStatus
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    success: function(data) {
                        checkbox.prop('disabled', false);
                        
                        if (data.status === 'success') {
                            if (typeof Command !== 'undefined' && Command.toastr) {
                                Command.toastr['success'](data.message || 'Enrollment updated successfully!');
                            } else if (typeof toastr !== 'undefined') {
                                toastr.success(data.message || 'Enrollment updated successfully!');
                            }
                            
                            // Reload page to show updated status
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            // Revert on error
                            checkbox.prop('checked', currentState);
                            if (typeof Command !== 'undefined' && Command.toastr) {
                                Command.toastr['error'](data.message || 'Failed to update enrollment');
                            } else if (typeof toastr !== 'undefined') {
                                toastr.error(data.message || 'Failed to update enrollment');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Revert checkbox state on error
                        checkbox.prop('checked', currentState);
                        checkbox.prop('disabled', false);
                        
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                const errorData = JSON.parse(xhr.responseText);
                                if (errorData.message) {
                                    errorMessage = errorData.message;
                                }
                            } catch (e) {
                                // Keep default message
                            }
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
                
                return false;
            });
        </script>
    @endpush
</x-dashboard-layout>
