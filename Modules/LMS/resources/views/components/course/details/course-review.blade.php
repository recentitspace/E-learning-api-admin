@php
    $reviews = review($course);
@endphp
<article>
    <h2 class="area-title xl:text-3xl mb-5">
        {{ translate('Course Reviews') }}
    </h2>
    <div class="flex flex-col md:flex-row items-center gap-4 border border-border rounded-2xl p-7">
        <div class="size-48 flex-center flex-col gap-3 bg-primary-50 overflow-hidden rounded-50 shrink-0">
            <h6 class="area-title !leading-none">{{ $reviews['average_rating'] }}</h6>
            <div class="flex items-center gap-0.5 text-secondary">
                {!! show_rating($reviews['average_rating']) !!}
            </div>
            <p class="area-description text-sm !leading-none">{{ translate('Out of') }}
                {{ $reviews['total_rating'] ?? 0 }} {{ translate('Rating') }}
            </p>
        </div>
        <div class="w-full grow">
            <table class="w-full">
                <tbody>
                    <tr>
                        <td class="px-2 py-1 w-10">
                            <div class="flex items-center gap-0.5 text-secondary">
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-fill text-sm"></i>
                            </div>
                        </td>
                        <td class="px-2 py-1">
                            <div class="relative w-full h-2 rounded-full bg-primary-50 overflow-hidden">
                                <div class="absolute inset-0 bg-primary rounded-full w-[100%]">
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-1 w-10">
                            <div class="text-heading/70 font-medium text-nowrap line-clamp-1">
                                {{ $reviews['rating']['5'] ?? 0 }} {{ translate('Rating') }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-2 py-1 w-10">
                            <div class="flex items-center gap-0.5 text-secondary">
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-line text-sm"></i>
                            </div>
                        </td>
                        <td class="px-2 py-1">
                            <div class="relative w-full h-2 rounded-full bg-primary-50 overflow-hidden">
                                <div class="absolute inset-0 bg-primary rounded-full w-[80%]">
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-1 w-10">
                            <div class="text-heading/70 font-medium text-nowrap line-clamp-1">
                                {{ $reviews['rating']['4'] ?? 0 }} {{ translate('Rating') }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-2 py-1 w-10">
                            <div class="flex items-center gap-0.5 text-secondary">
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-line text-sm"></i>
                                <i class="ri-star-line text-sm"></i>
                            </div>
                        </td>
                        <td class="px-2 py-1">
                            <div class="relative w-full h-2 rounded-full bg-primary-50 overflow-hidden">
                                <div class="absolute inset-0 bg-primary rounded-full w-[60%]">
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-1 w-10">
                            <div class="text-heading/70 font-medium text-nowrap line-clamp-1">
                                {{ $reviews['rating']['3'] ?? 0 }} {{ translate('Rating') }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-2 py-1 w-10">
                            <div class="flex items-center gap-0.5 text-secondary">
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-line text-sm"></i>
                                <i class="ri-star-line text-sm"></i>
                                <i class="ri-star-line text-sm"></i>
                            </div>
                        </td>
                        <td class="px-2 py-1">
                            <div class="relative w-full h-2 rounded-full bg-primary-50 overflow-hidden">
                                <div class="absolute inset-0 bg-primary rounded-full w-[40%]">
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-1 w-10">
                            <div class="text-heading/70 font-medium text-nowrap line-clamp-1">
                                {{ $reviews['rating']['2'] ?? 0 }} {{ translate('Rating') }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-2 py-1 w-10">
                            <div class="flex items-center gap-0.5 text-secondary">
                                <i class="ri-star-fill text-sm"></i>
                                <i class="ri-star-line text-sm"></i>
                                <i class="ri-star-line text-sm"></i>
                                <i class="ri-star-line text-sm"></i>
                                <i class="ri-star-line text-sm"></i>
                            </div>
                        </td>
                        <td class="px-2 py-1">
                            <div class="relative w-full h-2 rounded-full bg-primary-50 overflow-hidden">
                                <div class="absolute inset-0 bg-primary rounded-full w-[20%]">
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-1 w-10">
                            <div class="text-heading/70 font-medium text-nowrap line-clamp-1">
                                {{ $reviews['rating']['1'] ?? 0 }} {{ translate('Rating') }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</article>
