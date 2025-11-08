@php
    $instructors = $instructors ?? [];
    $totalInstructors = count($instructors);

    $instructorRoute = '';
    $instructorBtnText = '';

    if ($totalInstructors > 0) {
        $instructorRoute = route('instructor.list');
        $instructorBtnText = 'More Instructors';
    }

    if (isAdmin() && $totalInstructors < 1) {
        $instructorRoute = route('instructor.create');
        $instructorBtnText = 'Add Instructor';
    }
@endphp

<div class="bg-white py-16 sm:py-24 lg:py-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 xl:col-span-6 md:pr-20">
                <div class="area-subtitle">
                    {{ translate('Our Team Member') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('Meet Our Best') }}
                    <span class="title-highlight-one"> {{ translate('Instructors') }} </span>
                </h2>
            </div>
            @if ($instructorRoute && $instructorBtnText)
                <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                    <a href="{{ $instructorRoute }}" title="{{ $instructorBtnText }}"
                        class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium text-[16px] md:text-[18px]"
                        aria-label="{{ $instructorBtnText }}">
                        {{ translate($instructorBtnText) }}
                        <span class="hidden md:block">
                            <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                        </span>
                    </a>
                </div>
            @endif
        </div>
        <!-- BODY -->
        <div class="swiper instructor-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                <!-- SINGLE INSTRUCTOR -->
                @foreach ($instructors as $instructor)
                    <x-theme::cards.instructor-card-one :instructor="$instructor" />
                @endforeach
            </div>
        </div>
    </div>
</div>
