<div class="col-span-full lg:col-span-6 2xl:col-span-4 card px-0 order-2 2xl:order-none">
    <div class="flex-center-between px-6 mb-7">
        <h6 class="card-title"> {{ translate('Trending categories') }} </h6>
    </div>
    <div class="max-h-[350px] smooth-scrollbar" data-scrollbar>
        <ul class="divide-y divide-gray-200 dark:divide-dark-border-three space-y-5 *:pt-5 px-6">
            @foreach ($topCategories as $topCategory)
                @php
                    $categoryTranslations = parse_translation($topCategory);
                @endphp
                <li class="flex-center-between first:pt-0">
                    <div class="flex items-center gap-2.5">
                        <div
                            class="size-12 rounded-50 bg-primary-200 dark:bg-dark-icon flex-center flex-shrink-0 dk-theme-card-square">
                            <img src="{{ asset('lms/assets/images/icons/category/graphic-design.svg') }}" alt="icon">
                        </div>
                        <div>
                            <h6 class="leading-none text-heading dark:text-white font-semibold mb-2 line-clamp-1">
                                <a href="{{ route('course.index', "categories[]=$topCategory->id") }}"
                                    class="truncate">{{ $categoryTranslations['title'] ?? $topCategory->title }}</a>
                            </h6>
                            <p class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold">
                                {{ $topCategory->courses_count }}+ {{ translate('Courses') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('course.index', "categories[]=$topCategory->id") }}"
                        class="flex-center size-6 rounded-md bg-primary-200 dark:bg-dark-icon shrink-0">
                        <i class="ri-arrow-right-line text-gray-500 dark:text-dark-text text-[14px]"></i>
                    </a>
                </li>
            @endforeach

        </ul>
    </div>
</div>
