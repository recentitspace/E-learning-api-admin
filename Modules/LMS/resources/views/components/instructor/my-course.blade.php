<div class="pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <div class="area-subtitle">
                    {{ translate('Popular Courses') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('Explore My') }}
                    <span class="title-highlight-one">
                        {{ translate('Courses') }}
                    </span>
                </h2>
            </div>
        </div>
        <!-- BODY -->
        <div class="col-span-full lg:col-span-8">
            <div class="grid grid-cols-12 gap-4 xl:gap-7 mt-10">
                <x-theme::cards.course-card-one :courses="$courses" borderClass="true" />
            </div>
            <!-- PAGINATION -->
            {!! $courses->links('theme::pagination.pagination-one') !!}
        </div>
    </div>
</div>
