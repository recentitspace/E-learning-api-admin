<form action="{{ route('auth.login') }}" class="w-full max-w-screen-sm mt-10 form" method="POST">
    <div class="grid grid-cols-2 gap-x-3 gap-y-5">
        <div class="col-span-full">
            <div class="relative">
                <input type="email" name="email" id="role_email" class="form-input rounded-full peer" placeholder=""
                    required />
                <label for="role_email" class="form-label floating-form-label"> {{ translate('Email') }} <span
                        class="text-danger">*</span></label>
            </div>
            <span class="error-text email_err"></span>
        </div>
        <div class="col-span-full">
            <div class="relative">
                <input type="password" name="password" id="role_password" class="form-input rounded-full peer"
                    placeholder="" required />
                <label for="role_password" class="form-label floating-form-label">
                    {{ translate('Password') }}
                    <span class="text-danger">*</span>
                </label>
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
            <div class="flex-center-between px-4">
                <label class="flex items-center gap-2.5 cursor-pointer py-2.5 select-none">
                    <input type="checkbox" name="remember_me" class="checkbox checkbox-primary rounded-sm">
                    <span class="text-heading dark:text-white font-medium leading-none">
                        {{ translate('Remember me') }}
                    </span>
                </label>
                <div class="text-heading dark:text-white text-sm">
                    <a href="{{ route('password.request') }}" class="text-primary underline">
                        {{ translate('Forgot Password?') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-span-full">
            <button type="submit"
                class="btn b-solid btn-secondary-solid !text-heading dark:text-white btn-xl !rounded-full font-bold w-full h-12"
                aria-label="Login">
                {{ translate('Log in') }}
            </button>
        </div>
    </div>
</form>
