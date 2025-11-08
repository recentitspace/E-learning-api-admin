@php
    $reviews = review($course);
    $translations = parse_translation($course);
@endphp
<article>
    <h2 class="area-title text-2xl mb-5">{{ $translations['title'] ?? ($course->title ?? '') }}</h2>
    <div
        class="flex divide-x rtl:divide-x-reverse divide-border space-x-5 rtl:space-x-reverse [&>:not(:first-child)]:pl-5 rtl:[&>:not(:first-child)]:pl-0 rtl:[&>:not(:first-child)]:pr-5">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="flex items-center gap-0.5 text-secondary">
                    {!! show_rating($reviews['average_rating']) !!}
                </div>
                @if ($reviews['average_rating'])
                    <span
                        class="text-heading dark:text-white text-sm font-bold leading-none">{{ dotZeroRemove($reviews['average_rating']) }}</span>
                @endif
            </div>

            <div class="text-sm text-heading/60 mt-1">
                <strong>{{ $reviews['total_rating'] ?? 0 }}</strong> {{ translate('Ratings') }}
            </div>
        </div>
        <div class="flex flex-col items-start gap-px">
            <div class="text-heading dark:text-white text-sm font-bold leading-none">
                {{ $course?->totalPurchases->count() ?? 0 }}</div>
            <div class="text-sm text-heading/60 mt-1">
                {{ translate('Students') }}
            </div>
        </div>
        <div class="flex flex-col items-start gap-px">
            <div class="text-heading dark:text-white text-sm font-bold leading-none"> {{ $course->duration }}
                {{ translate('Hour') }} </div>
            <div class="text-sm text-heading/60 mt-1">{{ translate('Total') }}</div>
        </div>
    </div>
    <div class="text-heading dark:text-white text-sm font-bold leading-none mt-5">
        {{ translate('Last updated') }}
        {{ customDateFormate($course->updated_at, 'd M Y') }}
    </div>
</article>
