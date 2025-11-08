@php
    $thumbnail =
        $purchase?->course?->thumbnail && fileExists('lms/courses/thumbnails', $purchase?->course?->thumbnail) == true
            ? asset("storage/lms/courses/thumbnails/{$purchase?->course?->thumbnail}")
            : asset('lms/assets/images/placeholder/thumbnail612.jpg');

    $courseTranslations = parse_translation($purchase->course);
    $currency = $purchase?->course->coursePrice->currency ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
    $levels = $purchase?->course?->levels ?? [];

    $checkMethod = check_method_name($purchase, 'checkExpiredPurchaseWithSubscribe');
    if ($checkMethod) {
        $purchaseExpired = $purchase->checkExpiredPurchaseWithSubscribe($purchase->id, $purchase?->course_id);
    }

    $price = dotZeroRemove($purchase->price ?? 0);
    $purchasePrice = $price == 0 ? $purchase?->course?->coursePrice?->price : $price;

@endphp
<!-- Start Single Course Card -->
<div class="col-span-full sm:col-span-6 lg:col-span-4 3xl:col-span-3">
    <div
        class="flex flex-col bg-white dark:bg-dark-card-two rounded-xl duration-300 overflow-hidden hover:shadow-md group/blog h-full">
        <!-- COURSE THUMBNAIL -->
        <div class="relative aspect-[1.71] overflow-hidden shrink-0">
            @if ($purchase->subscribe_id)
                <span
                    class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 left-4 rtl:left-auto rtl:right-4 z-10">
                    {{ translate('Subscribe') }}
                </span>
            @endif
            <img src="{{ $thumbnail }}" alt="course-thumb"
                class="size-full object-cover group-hover/blog:scale-110 duration-300">
        </div>
        <!-- COURSE CONTENT -->
        <div class="flex flex-col px-4 lg:px-5 py-6 rounded-b-xl dk-border-one border-t-0 grow">
            <div class="flex-center justify-start gap-2.5 flex-wrap">
                <div class="flex items-center gap-1.5 area-description !text-primary text-sm !leading-none shrink-0">
                    <i class="ri-time-fill text-inherit"></i>
                    <div class="text-heading dark:text-dark-text-two">
                        {{ $purchase?->course?->duration }}
                    </div>
                </div>
                <div class="flex items-center gap-1.5 area-description !text-primary text-sm !leading-none shrink-0">
                    <i class="ri-graduation-cap-fill text-inherit"></i>
                    <div class="text-heading dark:text-dark-text-two">
                        @foreach ($levels as $level)
                            @php
                                $levelTranslations = parse_translation($level);
                            @endphp
                            @if ($loop->first)
                                {{ $levelTranslations['name'] ?? ($level->name ?? '') }}
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <h6
                class="text-heading dark:text-dark-text font-medium text-xl mt-5 mb-6 group-hover/blog:text-primary duration-300">
                @if (isset($purchaseExpired) && $purchaseExpired)
                    <a href="{{ route('course.detail', $purchase?->course?->slug) }}" class="line-clamp-2">
                        {{ $courseTranslations['title'] ?? $purchase->course?->title }}
                    </a>
                @else
                    <a href="{{ route('play.course', $purchase?->course?->slug) }}" class="line-clamp-2">
                        {{ $courseTranslations['title'] ?? $purchase->course?->title }}
                    </a>
                @endif
            </h6>
            <div class="flex-center-between gap-2 pt-4 mt-auto border-t border-heading/10 dark:border-dark-border-five">
                <div
                    class="text-heading dark:text-dark-text-two text-xl !leading-none font-medium flex items-center flex-wrap gap-1.5">
                    @if ($purchasePrice)
                        {{ $currencySymbol }}{{ $purchasePrice }}
                    @else
                        {{ translate('Free') }}
                    @endif
                </div>
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    @if (isset($purchaseExpired) && $purchaseExpired)
                        <a href="#" class="btn b-solid btn-danger-solid capitalize">
                            {{ translate('Subscription Plan Expired') }}
                        </a>
                    @else
                        <a href="{{ route('play.course', $purchase?->course?->slug) }}"
                            class="btn b-solid btn-primary-solid capitalize">
                            {{ translate('Continue') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
