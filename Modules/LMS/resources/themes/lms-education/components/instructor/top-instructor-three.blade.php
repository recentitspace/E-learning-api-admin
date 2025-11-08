<!-- START INSTRUCTOR AREA -->
<div class="py-16 sm:py-24 lg:py-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <div class="area-subtitle subtitle-outline style-two text-sm uppercase">
                    {{ translate('Team Member') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('Our Leadership Team') }}  
                </h2>
            </div>
        </div>
        <!-- BODY -->
        <div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7 mt-10 lg:mt-[60px]">
            @if (!empty($instructors))
                @foreach($instructors->take(2) as $instructor)
                    <x-theme::cards.instructor.card-three :instructor="$instructor" />
                @endforeach
            @endif
        </div>
        <!-- ALL INSTRUCTOR LINK -->
        <div class="flex-center mt-10 lg:mt-[60px]">
            <a
                href=" {{ route('instructor.list') }} "
                class="btn b-outline btn-primary-outline btn-xl font-bold"
                aria-label="View All Instructors"
            >
                {{ translate('View All Instructors') }}
            </a>
        </div>
    </div>
</div>
<!-- END INSTRUCTOR AREA -->