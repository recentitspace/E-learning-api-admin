@php
    $settings = [
        'components' => [
            'inner-header-top' => '',
        ],
    ];
@endphp

<x-auth-layout class="home-online-education" :data="$settings">
    <div class="min-w-full min-h-screen flex items-center">
        <div class="grow min-h-screen h-full w-full lg:w-1/2 p-3 bg-primary-50 hidden lg:flex-center">
            <img data-src="{{ asset('lms/frontend/assets/images/auth/auth-loti.svg') }}" alt="loti">
        </div>
        <div class="grow min-h-screen h-full w-full lg:w-1/2 pt-32 pb-12 px-3 lg:p-3 flex-center flex-col">
            <h2 class="area-title">{{ translate('Sign In') }}!</h2>
            <p class="area-description max-w-screen-sm mx-auto text-center mt-5">
                {{ translate('Discover, learn, and thrive with us. Experience a smooth and rewarding educational adventure. Let\'s get started') }}!
            </p>

            <div class="w-full max-w-screen-sm mt-10">
                <x-theme::form.login-form />
            </div>
            <div
                class="flex-center w-full max-w-screen-sm py-6 h-max relative text-heading dark:text-white font-normal before:absolute inset-0 before:w-full before:h-px before:bg-border">
                <span class="relative z-10 px-5 bg-white text-sm">{{ translate('OR') }}</span>
            </div>
            <div class="text-heading">
                {{ translate('Don\'t have an account yet') }}?
                <a href="{{ route('register.page') }}" class="text-primary hover:underline"
                    aria-label="Sign up page">{{ translate('Sign up') }}</a>
            </div>
        </div>
    </div>
</x-auth-layout>
