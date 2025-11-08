<x-dashboard-layout>
    <x-slot:title> {{ translate('Student Assignment') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="{{ $assignment->title ?? null }}" page-to="Assignment" />

    @if (!empty($studentAssignments) && $studentAssignments->count() > 0)
        <div class="card overflow-hidden">
            <div class="overflow-x-auto scrollbar-table">
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
                                {{ translate('Last Submission') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Attempts') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Pass Mark') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Total Mark') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Get Mark') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Status') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($studentAssignments as $studentAssignment)
                            @php
                                $user = $studentAssignment?->user->userable ?? null;

                                $userTranslations = parse_translation($user);

                            @endphp
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3.5">
                                        @if (isset($user) && fileExists('lms/students', $user->profile_img) == true && $user->profile_img != '')
                                            <div class="size-12 rounded-50 overflow-hidden dk-theme-card-square">
                                                <img src="{{ asset('storage/lms/students/' . $user->profile_img) }}"
                                                    alt="student" class="size-full object-cover">
                                            </div>
                                        @else
                                            <div class="size-12 rounded-50 overflow-hidden dk-theme-card-square">
                                                <img src="{{ asset('lms/assets/images/placeholder/profile.jpg') }}"
                                                    alt="student" class="size-full object-cover">
                                            </div>
                                        @endif
                                        <div>
                                            <h6
                                                class="leading-none text-heading dark:text-white font-semibold capitalize">
                                                <a href="#">
                                                    {{ $userTranslations['first_name'] ?? ($user->first_name ?? '') }}
                                                    {{ $userTranslations['last_name'] ?? ($user->last_name ?? ($userTranslations['name'] ?? ($user->name ?? ''))) }}
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ customDateFormate($studentAssignment->updated_at) }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $studentAssignment?->attempt_number }} /
                                    {{ $assignment->retake_number }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $assignment->pass_mark }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $assignment->total_mark }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $studentAssignment->score }}
                                </td>
                                <td class="px-3.5 py-4">
                                    @if ($studentAssignment->score >= $assignment->pass_mark)
                                        <span class="badge b-solid badge-primary-solid">{{ translate('Pass') }}</span>
                                    @else
                                        @if ($studentAssignment->score == null)
                                            <span class="badge b-solid badge-warning-solid">
                                                {{ translate('Pending') }}
                                            </span>
                                        @else
                                            <span class="badge b-solid badge-danger-solid">
                                                {{ translate('Failed') }}
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('exam.start', ['type' => $studentAssignment->exam_type, 'exam_type_id' => $studentAssignment->assignment_id, 'course_id' => $studentAssignment->course_id, 'student' => $studentAssignment->user_id]) }}"
                                            class="btn b-solid btn-info-solid btn-sm dk-theme-card-square"
                                            title="{{ translate('View Result') }}">
                                            {{ translate('View Result') }}
                                        </a>
                                        <a href="{{ route('course.detail', $studentAssignment?->course?->slug) }}"
                                            class="btn b-solid btn-info-solid btn-sm dk-theme-card-square"
                                            title="{{ translate('Go Course') }}">
                                            {{ translate('Go Course') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            {{ $studentAssignments->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="Yet, No student join this assignment" />
    @endif
</x-dashboard-layout>
