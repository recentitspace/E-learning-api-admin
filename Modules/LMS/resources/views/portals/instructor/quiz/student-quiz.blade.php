<x-dashboard-layout>
    <x-slot:title>{{ translate('Student Quiz') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Quiz" page-to="Quiz" back-url="{{ route('instructor.quiz.list') }}" />

    @if (!empty($studentQuizzes) && $studentQuizzes->count() > 0)
        <div class="card overflow-hidden">
            <h1 class="card-title mb-5"> {{ $quiz->title ?? '' }}</h1>
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
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($studentQuizzes as $studentQuizze)
                            @php
                                $user = $studentQuizze?->user->userable ?? null;
                                $profileImg =
                                    $user->profile_img && fileExists('lms/students', $user->profile_img) == true
                                        ? asset('storage/lms/students/' . $user->profile_img)
                                        : asset('lms/assets/images/placeholder/profile.jpg');

                                $userTranslations = parse_translation($user);

                            @endphp
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3.5">
                                        <a href="#" class="size-12 rounded-50 overflow-hidden">
                                            <img src="{{ $profileImg }}" alt="student"
                                                class="size-full object-cover">
                                        </a>
                                        <div>
                                            <h6
                                                class="leading-none text-heading dark:text-white font-semibold capitalize">
                                                <a href="#">
                                                    {{ $userTranslations['first_name'] ?? ($user->first_name ?? '') }}

                                                    {{ $userTranslations['last_name'] ?? ($user->last_name ?? '') }}
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ customDateFormate($studentQuizze->updated_at) }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $studentQuizze?->attempt_number }} /
                                    {{ $quiz->total_retake }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $quiz->pass_mark }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $quiz->total_mark }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $studentQuizze->score }}
                                </td>
                                <td class="px-3.5 py-4">
                                    @if ($studentQuizze->score >= $quiz->pass_mark)
                                        <span class="badge b-solid badge-primary-solid">
                                            {{ translate('Pass') }}
                                        </span>
                                    @else
                                        @if ($studentQuizze->score == null)
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
                                    <div class="flex items-center gap-1">
                                        @php
                                            if (
                                                isset(
                                                    $studentQuizze->exam_type,
                                                    $studentQuizze->quiz_id,
                                                    $studentQuizze->course_id,
                                                    $studentQuizze->user_id,
                                                )
                                            ) {
                                                $route = route('exam.start', [
                                                    'type' => $studentQuizze->exam_type,
                                                    'exam_type_id' => $studentQuizze->quiz_id,
                                                    'course_id' => $studentQuizze->course_id,
                                                    'student' => $studentQuizze->user_id,
                                                ]);
                                            }

                                        @endphp
                                        <a href="{{ $route ?? '#' }}"
                                            class="btn b-solid btn-info-solid btn-sm dk-theme-card-square"
                                            title="View Result">
                                            {{ translate('View Result') }}
                                        </a>
                                        <a href="{{ route('course.detail', $studentQuizze?->course?->slug) }}"
                                            class="btn b-solid btn-info-solid btn-sm dk-theme-card-square"
                                            title="Go Course">
                                            {{ translate('Go Course') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $studentQuizzes->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="Yet, No student join this Quiz" />
    @endif
</x-dashboard-layout>
