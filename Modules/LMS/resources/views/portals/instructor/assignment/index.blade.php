<x-dashboard-layout>
    <x-slot:title> {{ translate('Assignment Manage') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="All Assignment" page-to="Assignment" />
    <!-- Start Main Content -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto scrollbar-table">
            @if (isset($assignments) && !empty($assignments) && $assignments->count() > 0)
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
                                <td class=" items-center gap-2 px-3.5 py-4">
                                    <h6 class="leading-none text-heading dark:text-white font-bold mb-1.5 line-clamp-1">
                                        {{ $assignment?->topicable?->title ?? '' }}

                                    </h6>
                                    <p class="text-sm">
                                        {{ substr($assignment?->course?->title, 0, 40) . '...' ?? '' }}
                                    </p>
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ customDateFormate($assignment?->submission_date) }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $assignment?->topicable?->retake_number ?? '' }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $assignment?->topicable?->pass_mark ?? '' }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $assignment?->topicable?->total_mark ?? '' }}
                                </td>
                                <td class="px-3.5 py-4">
                                    @if (dateCompare($assignment?->topicable?->submission_date))
                                        <span class="badge b-outline badge-primary-outline"> {{ translate('Active') }}
                                        </span>
                                    @else
                                        <span class="badge b-outline badge-danger-outline"> {{ translate('Closed') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3.5 py-4">
                                    <a href="{{ route('instructor.student.assignment', $assignment->topicable_id) }}"
                                        class="btn b-solid btn-primary-solid btn-sm dk-theme-card-square"
                                        title="{{ translate('Go Course') }}">
                                        {{ translate('View All') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <x-portal::admin.empty-card title="No assignment" btnText="Add New" />
            @endif
        </div>
    </div>

</x-dashboard-layout>
