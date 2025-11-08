<div class="grid grid-cols-12 gap-4 xl:gap-7">
    @foreach ($courses as $course)
        <div class="col-span-full md:col-span-6">
            <x-theme::cards.course.card-one :course="$course" borderClass="true" />
        </div>
    @endforeach
</div>
