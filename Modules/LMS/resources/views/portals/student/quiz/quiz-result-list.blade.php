<x-dashboard-layout>
    <x-slot:title> {{ translate('My quizzes') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="My All quiz" page-to="quiz" />
    <!-- Start Main Content -->
    <div class="card overflow-hidden">
        @if ($userQuizzes->count() > 0)
            <div class="overflow-x-auto scrollbar-table">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary-500">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Quiz') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Quiz grade') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Pass Mark') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('My grade') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Status') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Date') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($userQuizzes as $userQuiz)
                            <tr>
                                <td class="px-3.5 py-4">
                                    <h6 class="leading-none text-heading dark:text-white font-bold mb-1.5 line-clamp-1">
                                        {{ $userQuiz->quiz->title ?? null }}
                                    </h6>
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $userQuiz?->quiz?->total_mark ?? 0 }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $userQuiz?->quiz?->pass_mark }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $userQuiz->score . '/' . $userQuiz?->quiz?->total_mark }}
                                </td>
                                <td class="px-3.5 py-4">
                                    @if ($userQuiz?->quiz?->pass_mark <= $userQuiz->score)
                                        <span class="badge b-solid badge-success-solid"> {{ translate('Pass') }}
                                        </span>
                                    @else
                                        <span class="badge b-solid badge-danger-solid"> {{ translate('Failed') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ customDateFormate($userQuiz->created_at, format: 'm D  Y') }}
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('exam.start', ['type' => $userQuiz->exam_type, 'exam_type_id' => $userQuiz->quiz_id, 'course_id' => $userQuiz->course_id]) }}"
                                            class="btn b-solid btn-info-solid btn-sm" title="{{ translate('View Result') }}">
                                            {{ translate('View Result') }}
                                        </a>

                                        <a href="{{ route('course.detail', $userQuiz?->course?->slug) }}"
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
        @else
            <x-portal::admin.empty-card title="No Quiz" />
        @endif
    </div>
</x-dashboard-layout>
