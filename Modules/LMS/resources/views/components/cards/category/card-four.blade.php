@php
    if ( ! $category ) {
        return;
    }
    $totalCourses = $category->courses_count ?? $category->courses->count();
    $totalCoursesText = Str::plural('+ Course', $totalCourses);
    $translations = parse_translation($category);
@endphp
<div class="col-span-full sm:col-span-6 lg:col-span-3">
    <div class="bg-section px-4 py-7 rounded-xl flex-center flex-col gap-1 border border-secondary/30 custom-transition h-full group/category">
        <h6 class="area-title text-base xl:text-xl font-bold text-center">
            {{ str_limit($translations['title'] ?? $category->title, 20) }}
        </h6>
        <p class="area-description text-heading/70">
            {{ "{$totalCourses}{$totalCoursesText}" }}
        </p>
    </div>
</div>