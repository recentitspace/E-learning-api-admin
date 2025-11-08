<x-auth-layout>
    <div class="min-w-full min-h-screen flex items-center">
        <div class="grow min-h-screen h-full w-full lg:w-1/2 p-3 bg-primary-50 hidden lg:flex-center">
            <img data-src="{{ asset('lms/frontend/assets/images/auth/auth-loti.svg') }}" alt="loti">
        </div>
        <div class="grow min-h-screen h-full w-full lg:w-1/2 pt-32 pb-12 px-3 lg:p-3 flex-center flex-col">
            <h2 class="area-title"> {{ !isset($token) ? translate('Reset your') : translate('Update your') }}
                {{ translate('Password') }}</h2>
            <p class="area-description max-w-screen-sm mx-auto text-center mt-5">
                {{ translate('No worries, it happens! Just enter your email, and we will help you unlock your account with a fresh password. Your learning journey is just a step away') }}!
            </p>
            <form action="{{ isset($token) ? route('password.update') : route('forgot.password') }}"
                class="w-full max-w-screen-sm mt-10 form" method="POST">
                @csrf
                @if (isset($token))
                    <input type="hidden" name="token" value="{{ $token }}">
                @endif
                <div class="grid grid-cols-2 gap-x-3 gap-y-5">
                    <div class="col-span-full">
                        <div class="relative">
                            <input type="email" id="user_email" name="email" class="form-input rounded-full peer"
                                placeholder="" />
                            <label for="user_email" class="form-label floating-form-label">{{ translate('Email') }}
                                <span class="text-danger">*</span></label>
                        </div>
                        <span class="error-text email_err"></span>
                    </div>

                    @if (isset($token))
                        <div class="col-span-full">
                            <div class="relative">
                                <input type="password" id="user_password" name="password"
                                    class="form-input rounded-full peer" placeholder="" />
                                <label for="user_password"
                                    class="form-label floating-form-label">{{ translate('Password') }} <span
                                        class="text-danger">*</span></label>
                                <!-- type toggler -->
                                <label
                                    class="size-8 rounded-full cursor-pointer flex-center hover:bg-gray-200 focus:bg-gray-200 absolute top-1/2 -translate-y-1/2 right-2 rtl:right-auto rtl:left-2">
                                    <input type="checkbox" class="inputTypeToggle peer/it" hidden>
                                    <i
                                        class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                                </label>
                            </div>
                            <span class="error-text password_err"></span>
                        </div>
                        <div class="col-span-full">
                            <div class="relative">
                                <input type="password" id="user_password_confirm" name="password_confirmation"
                                    class="form-input rounded-full peer" placeholder="" />
                                <label for="user_password"
                                    class="form-label floating-form-label">{{ translate('Confirm Password') }} <span
                                        class="text-danger">*</span></label>
                                <!-- type toggler -->
                                <label
                                    class="size-8 rounded-full cursor-pointer flex-center hover:bg-gray-200 focus:bg-gray-200 absolute top-1/2 -translate-y-1/2 right-2 rtl:right-auto rtl:left-2">
                                    <input type="checkbox" class="inputTypeToggle peer/it" hidden>
                                    <i
                                        class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                                </label>
                            </div>
                        </div>
                    @endif
                    <div class="col-span-full">
                        <button type="submit" aria-label="Update password"
                            class="btn b-solid btn-secondary-solid !text-heading dark:text-white btn-xl !rounded-full font-bold w-full h-12">
                            {{ !isset($token) ? translate('Send Request') : translate('Update Password') }}
                        </button>
                    </div>
                </div>
            </form>

            @if (!isset($token))
                <div
                    class="flex-center w-full max-w-screen-sm py-6 h-max relative text-heading dark:text-white font-normal before:absolute inset-0 before:w-full before:h-px before:bg-border">
                    <span class="relative z-10 px-5 bg-white text-sm">{{ translate('OR') }}</span>
                </div>
                <div class="w-full max-w-screen-sm">
                    <a href="{{ route('login') }}" aria-label="Back to login"
                        class="btn b-solid btn-primary-solid btn-xl !rounded-full font-bold w-full h-12">
                        <i class="ri-arrow-left-line"></i>
                        {{ translate('Back to Login') }}
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-auth-layout>
