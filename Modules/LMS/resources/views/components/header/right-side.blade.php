@php
    $isShowLanguage = $isShowLanguage ?? false;
    $textColor = $textColor ?? 'text-white';
    $loggedin = $data['loggedin'] ?? [];
    $login = $data['login'] ?? [];
    $register = $data['register'] ?? [];
    $wishlist = $data['wishlist'] ?? [];
    $cart = $data['cart'] ?? [];
    $user = authCheck()->userable ?? null;
@endphp


@auth
    @php
        $url = '#';
        $wishlistUrl = '#';
        if (isOrganization()) {
            $url = route('organization.dashboard');
            $wishlistUrl = route('organization.wishlist');
        }

        if (isInstructor()) {
            $url = route('instructor.dashboard');
            $wishlistUrl = route('instructor.wishlist');
        }

        if (isStudent()) {
            $url = route('student.dashboard');
            $wishlistUrl = route('student.wishlist');
        }
    @endphp
@endauth

@if ($isShowLanguage)
    <div class="flex items-center justify-end space-x-5 divide-x divide-white/15 [&>:not(:first-child)]:pl-5 grow">
        @if (count(app('languages')) > 0)
            <div class="flex items-center">
                <form method="get" action="{{ route('language.set') }}" id="language-form">
                    @csrf
                    <input type="hidden" name="admin_id"
                        value="{{ auth('admin')->check() ? auth('admin')->user()->id : null }}">
                    <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : null }}">
                    <select name="locale" aria-label="Choose Language"
                        onchange="event.preventDefault();
                    document.getElementById('language-form').submit();"
                        class="{{ $textColor }} *:text-heading dark:text-white font-semibold bg-transparent focus:outline-none cursor-pointer select-none text-sm bg-heading">
                        @foreach (app('languages') as $language)
                            <option value="{{ $language->code }}"
                                {{ app()->getLocale() == $language->code ? 'selected' : '' }}>
                                {{ $language->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        @endif
    </div>
@endif

@if ($wishlist['is_show'] ?? true)
    <a href="{{ $wishlistUrl ?? '#' }}" aria-label="Wishlist icon"
        class="{{ $wishlist['link_class'] ?? 'relative hidden md:flex-center text-white px-2 py-3 shrink-0' }}">
        <img data-src="{{ $wishlist['icon_image'] ?? asset('lms/frontend/assets/images/icons/wish-list.svg') }}"
            alt="Icon">
        <span
            class="total-wishlist {{ $wishlist['badge_class'] ?? 'flex-center size-6 rounded-50 bg-primary text-xs text-white border-2 border-white absolute top-0 -right-1 rtl:right-auto rtl:-left-1' }} ">
            @auth
                {{ count(authCheck()?->wishlists) }}
            @else
                0
            @endauth
        </span>
    </a>
@endif
<!-- CART LIST -->
@if ($cart['is_show'] ?? true)
    <a href="{{ $cart['url'] ?? route('cart.page') }}" aria-label="Cart icon"
        class="relative hidden md:flex text-heading px-2 py-3 shrink-0">
        <img data-src="{{ $cart['icon_image'] ?? asset('lms/frontend/assets/images/icons/cart.svg') }}" alt="Icon">
        <span
            class="{{ $cart['badge_class'] ?? 'flex-center size-6 rounded-50 bg-primary text-xs text-white border-2 border-white absolute top-0 -right-1 rtl:right-auto rtl:-left-1 total-qty' }}">{{ total_qty() }}</span>
    </a>
@endif
<!-- ACTION LINK -->
<div class="flex gap-4 shrink-0">
    @auth
        <a href="{{ $url }}" aria-label="Profile info"
            class="{{ $loggedin['link_class'] ?? 'btn b-outline btn-secondary-outline h-11 !rounded-full !text-heading font-semibold' }}">
            <span class="hidden md:block"><i class="ri-user-3-line"></i></span>
            {{ $user?->name ?? $user->first_name }}
        </a>
    @else
        @if (Auth::guard('admin')->check())
            <a href="{{ route('admin.dashboard') }}" aria-label="Profile info"
                class="{{ $loggedin['link_class'] ?? 'btn b-outline btn-secondary-outline h-11 !rounded-full !text-heading font-semibold' }}">
                <span class="hidden md:block"><i class="ri-user-3-line"></i></span>
                {{ auth('admin')->user()->name }}
            </a>
        @elseif ($login['is_show'] ?? true)
            <a href="{{ $login['url'] ?? route('login') }}" aria-label="Log in"
                class="{{ $login['link_class'] ?? 'flex btn b-outline btn-secondary-outline h-11 !rounded-full !text-heading font-semibold' }}">
                <span class="hidden md:block"><i class="ri-user-3-line"></i></span>
                {{ translate($login['label'] ?? 'Log In') }}
            </a>
        @endif
    @endauth
    @if (!Auth::guard('admin')->check() && !Auth::guard('web')->check() && ($register['is_show'] ?? true))
        <a href="{{ $register['url'] ?? route('auth.register') }}" aria-label="Registration"
            class="{{ $register['link_class'] ?? 'hidden md:flex btn b-solid btn-secondary-solid h-11 !rounded-full !text-heading font-semibold' }}">
            {{ translate($register['label'] ?? 'Sign up') }}
            @if ($register['show_icon'] ?? true)
                <span class="hidden md:block">
                    <i class="{{ $register['link_icon'] ?? 'ri-arrow-right-up-line' }}"></i>
                </span>
            @endif
        </a>
    @endif
</div>
