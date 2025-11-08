<x-dashboard-layout>
    <x-slot:title> {{ translate('Quiz Manage') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="All Quiz" page-to="Quiz" />

    @if (!empty($quizzes))
        <!-- Start Main Content -->
        <div class="card overflow-hidden">
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

                        @foreach ($quizzes as $quiz)
                            <tr>
                                <td class="px-3.5 py-4">
                                    <h6 class="leading-none text-heading dark:text-white font-bold mb-1.5 line-clamp-1">
                                        {{ $quiz?->topicable?->title ?? '' }}

                                    </h6>
                                    <p class="text-sm">{{ substr($quiz?->course?->title, 0, 40) . '...' ?? '' }}
                                    </p>
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $quiz?->topicable?->total_retake ?? '' }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $quiz?->topicable?->pass_mark ?? '' }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $quiz?->topicable?->total_mark ?? '' }}
                                </td>
                                <td class="px-3.5 py-4">
                                    @if (dateCompare($quiz?->topicable?->expire_date))
                                        <span class="badge b-outline badge-primary-outline">
                                            {{ translate('Active') }}
                                        </span>
                                    @else
                                        <span class="badge b-outline badge-danger-outline">
                                            {{ translate('Closed') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('instructor.student.quiz', $quiz->topicable_id) }}"
                                            class="btn b-solid btn-primary-solid btn-sm dk-theme-card-square"
                                            title="{{ translate('Go Course') }}">
                                            {{ translate('View All') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @else
        <x-portal::admin.empty-card title="No Quiz" btnText="Add New" />
    @endif
</x-dashboard-layout>
