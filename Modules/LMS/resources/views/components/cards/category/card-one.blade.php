@php
    $categoryImageName = $category->image ?? '';
    $translations = parse_translation($category);
@endphp

<div class="col-span-full sm:col-span-6 lg:col-span-3">
    <div class="relative bg-section rounded-[20px] px-4 xl:px-10 py-7 xl:py-12 flex-center flex-col border border-transparent hover:border-primary hover:shadow custom-transition h-full group/category">
        <div class="flex-center size-12">
            @if ($categoryImageName && fileExists('lms/categories', $categoryImageName) == true)
                <img data-src="{{ asset('storage/lms/categories/' . $categoryImageName) }}" alt="Category icon"
                    class="size-full object-cover rounded-lg">
            @elseif($category->icon_id)
                <div class="icon"> {!! $category?->icon?->icon ?? '' !!}</div>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" width="52" height="51" viewBox="0 0 52 51" fill="none">
                    <path
                        d="M2 12.8684H50M2 38.1316H50M15.8947 12.8684V2.76316M36.1053 12.8684V2.76316M15.8947 48.2368V38.1316M36.1053 48.2368V38.1316M2 25.5C2 14.1872 2 8.52821 5.51411 5.01411C9.02821 1.5 14.6846 1.5 26 1.5C37.3128 1.5 42.9718 1.5 46.4859 5.01411C50 8.52821 50 14.1846 50 25.5C50 36.8128 50 42.4718 46.4859 45.9859C42.9718 49.5 37.3154 49.5 26 49.5C14.6872 49.5 9.02821 49.5 5.51411 45.9859C2 42.4718 2 36.8154 2 25.5Z"
                        stroke="#111827" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M23 19.5L33 26L23 32.5V19.5Z" stroke="#111827" stroke-width="3" stroke-linejoin="round" />
                </svg>
            @endif
        </div>
        <h6 class="area-title text-[20px] text-center font-semibold mt-12 group-hover/category:text-primary custom-transition">
            {{ str_limit( $translations['title'] ?? $category->title, 20) }}
        </h6>
        <p class="area-description mt-2 font-normal text-center">
            {{ $category->courses->count() > 0 ? $category->courses->count() . '+ ' . translate('Course') : $category->courses->count() ?? 0 }}
            {{ translate('Available') }}
        </p>
        <a href="{{ route('course.list', ['categories' => $category->id]) }}"
            aria-label="View Category courses"
            class="btn text-heading dark:text-white group-hover/category:text-primary font-bold custom-transition mt-8 xl:mt-12"
        >
            {{ translate('View Category') }}
            <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
            <span class="absolute inset-0" aria-hidden="true"></span>
        </a>
    </div>
</div>
