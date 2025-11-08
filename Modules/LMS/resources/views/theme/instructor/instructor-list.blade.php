@if (count($instructors) > 0)
    <div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7 mt-10">
        @foreach ($instructors as $instructor)
            <x-theme::cards.instructor-card-one :instructor="$instructor" filter="yes" />
        @endforeach
    </div>
    <!-- PAGINATION -->
    {!! $instructors->links('theme::pagination.pagination-one') !!}
@else
    <x-theme::cards.empty title="No Instructor" />
@endif
