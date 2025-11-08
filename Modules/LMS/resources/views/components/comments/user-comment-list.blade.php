@foreach ($comments as $blogComment)
    @php
        $user = $blogComment->user->userable ?? null;

        $profileImg =
            $user->profile_img &&
            fileExists('lms/' . userImagePath($blogComment->user->guard) . '/', $user->profile_img) == true
                ? asset('storage/lms/' . userImagePath($blogComment->user->guard) . '/' . $user->profile_img)
                : asset('lms/frontend/assets/images/placeholder/profile.jpg');

    @endphp
    <li class="relative border border-border rounded-2xl p-6">
        @if (!isset($replay))
            @auth
                <div class="absolute top-6 right-6 rtl:right-auto rtl:left-6 z-10">
                    <button type="button" class="btn b-outline btn-secondary-outline btn-sm rounded-full reply-btn"
                        aria-label="Reply comment" data-id="{{ $blogComment->id }}">
                        {{ translate('Reply') }}
                    </button>
                </div>
            @endauth
        @endif

        <div class="flex items-center gap-3.5">
            <div class="size-12 overflow-hidden rounded-50 shrink-0">
                <img data-src="{{ $profileImg }}" alt="User profile image" class="size-full object-cover">
            </div>
            <div>
                <h6 class="area-title text-base !leading-none font-bold">
                    {{ $user->guard == 'organization' ? $user?->name : $user->first_name . ' ' . $user->last_name }}
                </h6>
                <div class="text-heading/60 text-sm leading-none mt-2">
                    {{ customDateFormate($blogComment->created_at, format: 'M d Y') }}
                </div>
            </div>
        </div>
        <div class="text-heading/70 font-semibold leading-[1.55] mt-6 grow">
            <p>
                {{ $blogComment->comment ?? '' }}
            </p>
        </div>
        <!-- REPLIED COMMENT LIST -->
        @if (!empty($blogComment->replies) && $blogComment->replies->count() > 0)
            <ul class="flex flex-col gap-5 mt-5">
                <x-theme::comments.user-comment-list :comments="$blogComment->replies" replay="false" />
            </ul>
        @endif
    </li>
@endforeach
