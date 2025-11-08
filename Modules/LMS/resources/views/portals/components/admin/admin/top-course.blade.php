<!-- Course Table -->
<div class="overflow-x-auto scrollbar-table max-h-[350px] smooth-scrollbar" data-scrollbar>

    @if ($topCourses->count() > 0)
        <table
            class="table-auto w-full whitespace-nowrap text-left text-xs text-gray-500 dark:text-dark-text font-semibold leading-none">
            <thead>
                <tr>
                    <th
                        class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                        {{ translate('Course') }}
                    </th>
                    <th
                        class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                        {{ translate('Publish on') }}
                    </th>
                    @if (isset($sales))
                        <th
                            class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                            {{ translate('Total Sale') }}
                        </th>
                    @else
                        <th
                            class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                            {{ translate('Enrolled') }}
                        </th>
                    @endif
                    <th
                        class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                        {{ translate('Price') }}
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dashed divide-gray-900/60 dark:divide-dark-border-three">
                @foreach ($topCourses as $course)
                    @php
                        $thumbnail =
                            $course->thumbnail && fileExists('lms/courses/thumbnails', $course->thumbnail) == true
                                ? asset("storage/lms/courses/thumbnails/{$course->thumbnail}")
                                : asset('lms/assets/images/placeholder/thumbnail612.jpg');

                        $translations = parse_translation($course);

                    @endphp
                    <tr>
                        <td class="px-3.5 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('course.detail', $course->slug) }}"
                                    class="size-10 rounded-50 overflow-hidden dk-theme-card-square">
                                    <img src="{{ $thumbnail }}" alt="thumb" class="size-full object-cover">
                                </a>
                                <div>
                                    <h6 class="text-heading dark:text-white font-semibold mb-1.5 line-clamp-1">
                                        <a target="_blank"
                                            href="{{ route('course.detail', $course->slug) }}">{{ str_limit($translations['title'] ?? $course->title, 15) }}</a>
                                    </h6>
                                    <p class="font-normal">{{ translate('Author') }} -
                                        @foreach ($course->instructors as $instructor)
                                            @php
                                                $userTranslations = parse_translation($instructor?->userable);
                                            @endphp

                                            {{ $userTranslations['first_name'] ?? $instructor?->userable?->first_name }}
                                            {{ $userTranslations['last_name'] ?? $instructor?->userable?->last_name }}

                                            {{ !$loop->last ?? '|' }}
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-3.5 py-4">{{ customDateFormate($course->created_at, 'd M Y') }}</td>

                        @if (isset($sales))
                            <td class="px-3.5 py-4">{{ $course->sale_count_number ?? 0 }}</td>
                        @else
                            <td class="px-3.5 py-4">{{ $course->enrollments_count }}</td>
                        @endif
                        <td class="px-3.5 py-4">
                            {{ $course?->courseSetting?->is_free ? translate('free') : $course?->coursePrice?->price }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <x-portal::admin.empty-card title="No top Courses" />
    @endif
</div>
