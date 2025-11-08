<div class="overflow-x-auto scrollbar-table">
    <table
        class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
        <thead class="text-primary-500">
            <tr>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Title/Course') }}
                </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Deadline') }}
                </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Total Mark') }}
                </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Pass Mark') }}
                </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Your Mark') }}
                </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Attempts') }}
                </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Date') }}
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
            @foreach ($assignments as $assignment)
                <tr>
                    <td class="px-3.5 py-4">
                        <h6 class="leading-none text-heading dark:text-dark-text font-bold mb-1.5 line-clamp-1">
                            {{ $assignment?->assignment?->title ?? null }}
                        </h6>
                        <p class="text-sm dark:text-dark-text-two">{{ $assignment?->course?->title ?? null }}</p>
                    </td>
                    <td class="px-3.5 py-4">
                        {{ customDateFormate($assignment?->assignment?->submission_date) }}
                    </td>
                    <td class="px-3.5 py-4">
                        {{ $assignment?->assignment?->total_mark }}
                    </td>
                    <td class="px-3.5 py-4">
                        {{ $assignment?->assignment?->pass_mark }}
                    </td>
                    <td class="px-3.5 py-4">
                        {{ $assignment->score }}
                    </td>
                    <td class="px-3.5 py-4">
                        {{ $assignment?->attempt_number }} / {{ $assignment?->assignment?->retake_number }}
                    </td>
                    <td class="px-3.5 py-4">
                        {{ customDateFormate($assignment->created_at, format: 'm D  Y') }}
                    </td>
                    <td class="px-3.5 py-4">
                        @if ($assignment?->assignment?->pass_mark <= $assignment->score)
                            <span class="badge b-solid badge-success-solid">{{ translate('Pass') }}</span>
                        @else
                            @if ($assignment->score == null)
                                <span class="badge b-solid badge-warning-solid">{{ translate('Pending') }}</span>
                            @else
                                <span class="badge b-solid badge-danger-solid">{{ translate('Failed') }}</span>
                            @endif
                        @endif
                    </td>
                    <td class="px-3.5 py-4">
                        <div class="flex items-center gap-1">
                            <a href="{{ route('exam.start', ['type' => $assignment->exam_type, 'exam_type_id' => $assignment->assignment_id, 'course_id' => $assignment->course_id]) }}"
                                class="btn b-solid btn-info-solid btn-sm" title="{{ translate('View Result') }}">
                                {{ translate('View Result') }}
                            </a>
                            <a href="{{ route('course.detail', $assignment?->course?->slug) }}"
                                class="btn b-solid btn-info-solid btn-sm" title="{{ translate('Go Course') }}">
                                {{ translate('Go Course') }}
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
