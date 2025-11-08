<!-- Notification Button -->
<div class="relative">
    <button type="button" data-popover-target="dropdownNotification" data-popover-trigger="click"
        data-popover-placement="bottom-end"
        class="relative size-8 flex-center hover:bg-gray-200 dark:hover:bg-dark-icon rounded-md">
        <i class="ri-notification-3-line text-[24px]"></i>
        <span
            class="absolute -top-1 -right-1 size-4 rounded-50 flex-center bg-primary-500 leading-none text-xs text-white">{{ $notifications->count() }}</span>
    </button>
    <!-- Dropdown menu -->
    <div id="dropdownNotification"
        class="!-right-full rtl:!right-auto rtl:!-left-full sm:!right-0 rtl:sm:!right-auto rtl:sm:!left-0 z-backdrop invisible w-[250px] sm:w-[420px] bg-white divide-y divide-gray-100 rounded-lg shadow border-[0.5px] border-gray-500/20 dark:bg-dark-card-shade dark:divide-dark-border-four dk-theme-card-square">
        <div
            class="block px-4 py-2 font-medium text-center text-heading dark:text-white rounded-t-lg bg-gray-50 dark:bg-dark-card-two">
            {{ translate('Notifications') }}
        </div>
        <div class="max-h-[350px] smooth-scrollbar divide-y divide-gray-100" data-scrollbar>
            @if (!$notifications->count())
                <div class="w-full h-[200px] flex-center text-sm text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('No notification Available') }}
                </div>
            @endif
            @foreach ($notifications as $notification)
                <a href="{{ isset($singleRoute) && $singleRoute ? route($singleRoute, $notification->id) : '' }}"
                    class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-dark-icon">
                    <div class="flex-shrink-0">
                        <img class="size-10 rounded-50 dk-theme-card-square"
                            src="{{ asset('lms/assets/images/placeholder/profile.jpg') }}" alt="Thumbnail image"
                            class="size-full object-cover">
                    </div>
                    <div class="w-full ps-3">
                        <div class="text-gray-500 dark:text-dark-text text-sm mb-1.5 !font-public_sans">
                            {{ $notification?->data['title'] }}
                            <span class="font-semibold text-gray-900">{!! clean(isset($notification?->data['message']) ? $notification?->data['message'] : '') !!}
                        </div>
                        <div class="text-xs text-blue-600">
                            {{ $notification?->created_at?->diffForHumans(['options' => 0]) }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        @if ($notifications->count() > 0)
            <a href="{{ $route }}"
                class="flex-center py-2 text-sm font-medium text-center text-heading dark:text-white bg-gray-50 dark:bg-dark-card-shade hover:bg-gray-100 dark:hover:bg-dark-icon">
                {{ translate('View all') }}
            </a>
            <div class="flex-center py-2 text-sm font-medium text-center bg-gray-100 dark:bg-dark-card-shade">
                <a class="text-heading dark:!text-white" href="{{ $readRoute }}">{{ translate('Mark all as read') }}
                </a>
            </div>
        @endif
    </div>
</div>
