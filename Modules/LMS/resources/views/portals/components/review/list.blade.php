@php
    $editRoute = 'course-review.edit';
    $deleteRoute = 'course-review.destroy';

    if (isOrganization()) {
        $editRoute = 'organization.course-review.edit';
        $deleteRoute = 'organization.course-review.destroy';
    }

    if (isInstructor()) {
        $editRoute = 'instructor.course-review.edit';
        $deleteRoute = 'instructor.course-review.destroy';
    }
    $isStudent = isStudent();
    if ($isStudent) {
        $editRoute = 'student.course-review.edit';
        $deleteRoute = 'student.course-review.destroy';
    }
@endphp

<table
    class="table-auto border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium">
    <thead>
        <tr class="text-primary-500">
            <th
                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                {{ translate('User') }}
            </th>
            <th
                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                {{ translate('Course Title') }}
            </th>
            <th
                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                {{ translate('Author') }}
            </th>
            <th
                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                {{ translate('Review') }}
            </th>
            <th
                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                {{ translate('Rating') }}
            </th>
            @if (!$isStudent)
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                    {{ translate('Action') }}
                </th>
            @endif
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
        @foreach ($reviews as $review)
            @php
                $rating = ($review->support_quality + $review->content_quality + $review->instructor_skills) / 3;
                $average_rating = round($rating);

                $student = $review->user->userable ?? null;
                $translations = parse_translation($student);
                $courseTranslations = parse_translation($review->course);
                $title = '';
                $instructors = $review->course->instructors ?? [];
            @endphp
            <tr>
                <td class="px-4 py-4">
                    {{ $translations['first_name'] ?? ($student->first_name ?? '') }}
                    {{ $translations['last_name'] ?? ($student->last_name ?? '') }}
                </td>
                <td class="px-4 py-4">
                    {{ $courseTranslations['title'] ?? ($review?->course?->title ?? '') }}
                </td>
                <td class="px-4 py-4">
                    @foreach ($instructors as $instructor)
                        @php
                            $userInfo = $instructor->userable ?? null;
                            $courseTranslations = parse_translation($userInfo);
                        @endphp
                    @endforeach
                    {{ $userInfo->first_name ?? '' }}
                    {{ $userInfo->last_name ?? '' }}
                </td>
                <td class="px-4 py-4">
                    {{ $review->content }}
                </td>
                <td class="px-4 py-4 text-warning">
                    {!! show_rating($average_rating) !!}
                </td>

                @if (!$isStudent)
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route($editRoute, $review->id) }}"
                                class="btn-icon btn-primary-icon-light size-8">
                                <i class="ri-edit-2-line text-inherit text-base"></i>
                            </a>
                            <button data-action="{{ route($deleteRoute, $review->id) }}"
                                class="btn-icon btn-danger-icon-light size-8 delete-btn-cs">
                                <i class="ri-delete-bin-line text-inherit text-base"></i>
                            </button>
                        </div>
                    </td>
                @endif

            </tr>
        @endforeach
    </tbody>
</table>
