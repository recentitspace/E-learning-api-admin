@if (count($courses) > 0)
    <div class="grid grid-cols-12 gap-4 xl:gap-7 mt-10">
        @foreach ($courses as $course)
            <x-theme::cards.course-list-card-one :course="$course" />
        @endforeach
    </div>
    {!! $courses->links('theme::pagination.pagination-one') !!}
@else
    <x-theme::cards.empty btnAction="{{ route('course.list') }}" title="No course" />
@endif
