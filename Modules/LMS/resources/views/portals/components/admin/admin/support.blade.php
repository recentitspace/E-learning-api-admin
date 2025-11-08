<div class="col-span-full lg:col-span-6 2xl:col-span-4 card px-0 order-3 2xl:order-none">
    <div class="flex-center-between px-6 mb-7">
        <h6 class="card-title">{{ translate('Support request') }}</h6>
        @if (count($supports) > 0)
            <a href="{{ route('support-ticket.ticket.index') }}"
                class="btn b-solid btn-primary-solid btn-sm dk-theme-card-square">
                {{ translate('See all') }}
            </a>
        @endif
    </div>
    <div class="max-h-[350px] smooth-scrollbar" data-scrollbar>
        <ul class="break-all divide-y divide-gray-200 dark:divide-dark-border-three space-y-5 *:pt-5 px-6">
            @foreach ($supports as $support)
                @php
                    $user = $support?->user?->userable ?? null;
                    $profileImg = $user?->profile_img;
                    $imagePath = userImagePath($support?->user?->guard);
                    $profileImg =
                        fileExists("lms/{$imagePath}", $profileImg) == true && $profileImg != ''
                            ? asset("storage/lms/{$imagePath}/" . $profileImg)
                            : asset('lms/assets/images/placeholder/profile.jpg');

                    $userTranslations = parse_translation($user);
                @endphp

                <li class="flex items-center gap-2.5 first:pt-0">
                    <a href="#" class="size-12 rounded-50 flex-shrink-0 overflow-hidden dk-theme-card-square">
                        <img src="{{ $profileImg }}" class="size-full object-cover" alt="Thumbnail image">
                    </a>
                    <div>
                        <div class="leading-none text-xs text-gray-500 dark:text-dark-text-two mb-1">
                            {{ customDateFormate($support->created_at, 'h:i a') }}
                        </div>
                        <h6 class="leading-none text-heading dark:text-white font-semibold mb-2">
                            @if (isset($user?->name))
                                {{ $userTranslations['name'] ?? ($user?->name ?? '') }}
                            @else
                                {{ $userTranslations['first_name'] ?? $user->first_name ?? '' }}
                                {{ $userTranslations['last_name'] ?? $user->last_name ?? '' }}
                            @endif
                        </h6>
                        <div
                            class="leading-none text-xs text-gray-500 dark:text-dark-text-two font-semibold line-clamp-1">
                            {!! $support?->title !!}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
