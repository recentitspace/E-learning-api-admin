@php
    $counter = get_theme_option(key: 'counter') ?? [];
    $totalExperience = $counter['total_experience'] ?? 1;
    $totalCourse = get_all_course('approved')->count() ?? [];
    $totalCourseText = $totalCourse > 0 ? 'Course' : 'Courses';
    $totalTutor = get_all_instructor()->count() ?? [];
    $totalTutorText = $totalTutor > 1 ? 'Expert Tutors' : 'Expert Tutor';
    $totalStudent = get_all_student()->count() ?? [];
    $totalStudentText = $totalStudent > 1 ? 'Satisfied Students' : 'Satisfied Student';
@endphp
<!-- counter -->
<div class="container max-w-[1600px] my-16 sm:my-24 lg:my-[120px]">
    <div class="bg-primary px-10 py-[60px] rounded-[20px]">
        <div class="grid grid-cols-12 divide-y lg:divide-y-0 lg:divide-x rtl:lg:divide-x-reverse divide-white/15">
            <div
                class="col-span-full lg:col-span-3 [&:not(:first-child)]:pt-4 [&:not(:first-child)]:lg:pt-0 [&:not(:first-child)]:lg:pl-4 [&:not(:first-child)]:mt-4 [&:not(:first-child)]:lg:mt-0 [&:not(:first-child)]:lg:ml-4">
                <div class="flex-center flex-col gap-3.5">
                    <div class="text-white text-lg font-bold leading-none">
                        {{ translate($totalCourseText) }}
                    </div>
                    <h6 class="text-white text-[54px] font-extrabold leading-none">
                        {{ $totalCourse > 1 ? $totalCourse . '+' : $totalCourse }}
                    </h6>
                </div>
            </div>
            <div
                class="col-span-full lg:col-span-3 [&:not(:first-child)]:pt-4 [&:not(:first-child)]:lg:pt-0 [&:not(:first-child)]:lg:pl-4 [&:not(:first-child)]:mt-4 [&:not(:first-child)]:lg:mt-0 [&:not(:first-child)]:lg:ml-4">
                <div class="flex-center flex-col gap-3.5">
                    <div class="text-white text-lg font-bold leading-none">
                        {{ translate('Years Experience') }}
                    </div>
                    <h6 class="text-white text-[54px] font-extrabold leading-none">
                        {{ $totalExperience > 1 ? $totalExperience . '+' : 0 }}
                    </h6>
                </div>
            </div>
            <div
                class="col-span-full lg:col-span-3 [&:not(:first-child)]:pt-4 [&:not(:first-child)]:lg:pt-0 [&:not(:first-child)]:lg:pl-4 [&:not(:first-child)]:mt-4 [&:not(:first-child)]:lg:mt-0 [&:not(:first-child)]:lg:ml-4">
                <div class="flex-center flex-col gap-3.5">
                    <div class="text-white text-lg font-bold leading-none">
                        {{ translate($totalTutorText) }}
                    </div>
                    <h6 class="text-white text-[54px] font-extrabold leading-none">
                        {{ $totalTutor > 1 ? $totalTutor . '+' : $totalTutor }}
                    </h6>
                </div>
            </div>
            <div
                class="col-span-full lg:col-span-3 [&:not(:first-child)]:pt-4 [&:not(:first-child)]:lg:pt-0 [&:not(:first-child)]:lg:pl-4 [&:not(:first-child)]:mt-4 [&:not(:first-child)]:lg:mt-0 [&:not(:first-child)]:lg:ml-4">
                <div class="flex-center flex-col gap-3.5">
                    <div class="text-white text-lg font-bold leading-none">
                        {{ translate($totalStudentText) }}
                    </div>
                    <h6 class="text-white text-[54px] font-extrabold leading-none">
                        {{ $totalStudent > 1 ? $totalStudent . '+' : $totalStudent }}
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>
