@php
    $bundle = $bundlesPurchase?->courseBundle ?? [];
    $currency = $bundle?->currency ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
    $checkMethod = check_method_name($bundle, 'checkExpiredPurchaseWithSubscribe');
    if ($checkMethod) {
        $purchaseExpired = $bundle->checkExpiredPurchaseWithSubscribe(
            $bundlesPurchase->id,
            $bundlesPurchase?->bundle_id,
        );
    }
@endphp
@if ($bundle->courses()->count() > 0)
    @php
        $thumbnail =
            $bundle?->thumbnail && fileExists('lms/courses/bundles', $bundle?->thumbnail) == true
                ? asset('storage/lms/courses/bundles/' . $bundle?->thumbnail)
                : asset('lms/assets/images/placeholder/thumbnail612.jpg');
        $bundleTranslations = parse_translation($bundle);
    @endphp

    <!-- Start Single Course Card -->
    <div class="col-span-full sm:col-span-6 lg:col-span-4 3xl:col-span-3">
        <div
            class="flex flex-col bg-white dark:bg-dark-card-two rounded-xl duration-300 overflow-hidden hover:shadow-md group/blog h-full">
            <!-- COURSE THUMBNAIL -->
            <div class="relative aspect-[1.71] overflow-hidden shrink-0">
                <img src="{{ $thumbnail }}" alt="course-thumb"
                    class="size-full object-cover group-hover/blog:scale-110 duration-300">
                @if ($bundlesPurchase->subscribe_id)
                    <span
                        class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 left-4 rtl:left-auto rtl:right-4 z-10">
                        {{ translate('Subscribe') }}
                    </span>
                @endif
            </div>
            <!-- COURSE CONTENT -->
            <div class="flex flex-col px-4 lg:px-5 py-6 rounded-b-xl dk-border-one border-t-0 grow">
                <h6
                    class="text-heading dark:text-dark-text font-medium text-xl mb-6 group-hover/blog:text-primary duration-300">
                    <a target="_blank" href="{{ route('bundle.detail', $bundle?->slug) }}" class="line-clamp-2">
                        {{ $bundleTranslations['title'] ?? $bundle?->title }}
                    </a>
                </h6>
                <div
                    class="flex-center-between gap-2 pt-4 mt-auto border-t border-heading/10 dark:border-dark-border-five">
                    @if (!$bundlesPurchase->subscribe_id)
                        <div
                            class="text-heading dark:text-dark-text-two text-xl !leading-none font-medium flex items-center flex-wrap gap-1.5">
                            {{ $currencySymbol }}{{ $bundlesPurchase->price }}
                        </div>
                    @endif

                    <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                        @if (isset($purchaseExpired) && $purchaseExpired)
                            <a href="#" class="btn b-solid btn-danger-solid capitalize">
                                {{ translate('Subscription Plan Expired') }}
                            </a>
                        @else
                            <a href="{{ route('bundle.detail', $bundle->slug) }}"
                                class="btn b-solid btn-primary-solid capitalize">
                                {{ translate('Continue') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <x-portal::admin.empty-card title="You have no bundle course to show" />
@endif
