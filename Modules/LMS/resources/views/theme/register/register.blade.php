<x-auth-layout>
    <div class="min-w-full min-h-screen flex items-center">
        <div class="grow min-h-screen h-full w-full lg:w-1/2 p-3 bg-primary-50 hidden lg:flex-center">
            <img data-src="{{ asset('lms/frontend/assets/images/auth/auth-loti.svg') }}" alt="loti">
        </div>
        <div class="grow min-h-screen h-full w-full lg:w-1/2 pt-32 pb-12 px-3 lg:p-3 flex-center flex-col">
            <h2 class="area-title">{{ translate('Register') }}!</h2>
            <p class="area-description max-w-screen-sm mx-auto text-center mt-5">
                {{ translate('Discover, learn, and thrive with us. Experience a smooth and rewarding educational adventure.Let\'s get started') }}!
            </p>
            <div class="dashkit-tab flex-center gap-2 flex-wrap mt-10" id="userRegisterTab">
                <button type="button" aria-label="User registration tab for Student"
                    class="dashkit-tab-btn btn b-light btn-primary-light btn-lg h-11 !rounded-full text-[14px] sm:text-[16px] md:text-[18px] [&.active]:bg-primary [&.active]:text-white active"
                    id="asStudent">{{ translate('Student') }}</button>
                <button type="button" aria-label="User registration tab for Instructor"
                    class="dashkit-tab-btn btn b-light btn-primary-light btn-lg h-11 !rounded-full text-[14px] sm:text-[16px] md:text-[18px] [&.active]:bg-primary [&.active]:text-white"
                    id="asInstructor">{{ translate('Instructor') }}</button>
                <button type="button" aria-label="User registration tab for Organization"
                    class="dashkit-tab-btn btn b-light btn-primary-light btn-lg h-11 !rounded-full text-[14px] sm:text-[16px] md:text-[18px] [&.active]:bg-primary [&.active]:text-white"
                    id="asOrganization">{{ translate('Organization') }}</button>
            </div>
            <div class="dashkit-tab-content mt-10 w-full max-w-screen-sm *:hidden" id="userRegisterTabContent">

                <!-- JOIN AS STUDENT -->
                <div class="dashkit-tab-pane !block" data-tab="asStudent">
                    <form action="{{ route('auth.register') }}" class="form" method="POST">
                        @csrf
                        <input type="hidden" name="user_type" value="student">
                        <div class="grid grid-cols-2 gap-x-3 gap-y-5">
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="text" id="std_first_name" name="first_name"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="std_first_name" class="form-label floating-form-label">{{ translate('First Name') }} <span
                                            class="text-danger">*</span></label>
                                </div>
                                <span class="error-text first_name_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="text" id="std_last_name" name="last_name"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="std_last_name" class="form-label floating-form-label">{{ translate('Last Name') }} <span
                                            class="text-danger">*</span></label>
                                </div>
                                <span class="error-text last_name_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="email" id="std_email" name="email"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="std_email" class="form-label floating-form-label">{{ translate('Email') }} <span
                                            class="text-danger">*</span></label>
                                </div>
                                <span class="error-text email_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="text" id="std_phone" name="phone"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="std_phone" class="form-label floating-form-label">{{ translate('Phone') }} <span
                                            class="text-danger">*</span></label>
                                </div>
                                <span class="error-text phone_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="password" id="std_password" name="password"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="std_password" class="form-label floating-form-label">{{ translate('Password') }} <span
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
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="password" id="std_password_confirmation" name="password_confirmation"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="std_password_confirmation" class="form-label floating-form-label">{{ translate('Confirm Password') }} <span class="text-danger">*</span></label>
                                    <!-- type toggler -->
                                    <label for="std_confirm_pass"
                                        class="size-8 rounded-full cursor-pointer flex-center hover:bg-gray-200 focus:bg-gray-200 absolute top-1/2 -translate-y-1/2 right-2 rtl:right-auto rtl:left-2">
                                        <input type="checkbox" id="std_confirm_pass" class="inputTypeToggle peer/it"
                                            hidden>
                                        <i
                                            class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <button type="submit" aria-label="Sign up"
                                    class="btn b-solid btn-secondary-solid !text-heading dark:text-white btn-xl !rounded-full font-bold w-full h-12">
                                    {{ translate('Sign Up') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- JOIN AS INSTRUCTOR -->
                <div class="dashkit-tab-pane" data-tab="asInstructor">
                    <form action="{{ route('auth.register') }}" method="POST" class="form">
                        @csrf
                        <input type="hidden" name="user_type" value="instructor">
                        <div class="grid grid-cols-2 gap-x-3 gap-y-5">
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="text" id="ins_first_name" name="first_name"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="ins_first_name" class="form-label floating-form-label">{{ translate('First Name') }} <span
                                            class="text-danger">*</span></label>
                                </div>
                                <span class="error-text first_name_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="text" id="ins_last_name" name="last_name"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="ins_last_name" class="form-label floating-form-label">{{ translate('Last Name') }} <span
                                            class="text-danger">*</span></label>
                                </div>
                                <span class="error-text last_name_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="email" id="ins_email" name="email"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="ins_email" class="form-label floating-form-label">{{ translate('Email') }} <span
                                            class="text-danger">*</span></label>
                                </div>
                                <span class="error-text email_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="text" id="ins_phone" name="phone"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="ins_phone" class="form-label floating-form-label">{{ translate('Phone') }} <span
                                            class="text-danger">*</span></label>
                                </div>
                                <span class="error-text phone_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="password" id="ins_password" name="password"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="ins_password" class="form-label floating-form-label">{{ translate('Password') }} <span
                                            class="text-danger">*</span></label>
                                    <!-- type toggler -->
                                    <label for="ins_first_pass"
                                        class="size-8 rounded-full cursor-pointer flex-center hover:bg-gray-200 focus:bg-gray-200 absolute top-1/2 -translate-y-1/2 right-2 rtl:right-auto rtl:left-2">
                                        <input type="checkbox" id="ins_first_pass" class="inputTypeToggle peer/it"
                                            hidden>
                                        <i
                                            class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                                    </label>
                                </div>
                                <span class="error-text password_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="password" id="ins_password_confirmation"
                                        name="password_confirmation" class="form-input rounded-full peer"
                                        placeholder="" />
                                    <label for="ins_password_confirmation"
                                        class="form-label floating-form-label">{{ translate('Confirm Password') }} <span class="text-danger">*</span></label>
                                    <!-- type toggler -->
                                    <label for="ins_confirm_pass"
                                        class="size-8 rounded-full cursor-pointer flex-center hover:bg-gray-200 focus:bg-gray-200 absolute top-1/2 -translate-y-1/2 right-2 rtl:right-auto rtl:left-2">
                                        <input type="checkbox" id="ins_confirm_pass" class="inputTypeToggle peer/it"
                                            hidden>
                                        <i
                                            class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                                    </label>
                                </div>

                            </div>
                            <div class="col-span-full">
                                <div class="relative">
                                    <input type="text" id="ins_designation" name="designation"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="ins_designation" class="form-label floating-form-label">{{ translate('Designation') }}
                                        <span class="text-danger">*</span></label>
                                </div>
                                <span class="error-text designation_err"></span>
                            </div>
                            <div class="col-span-full">
                                <button type="submit" aria-label="Sign up"
                                    class="btn b-solid btn-secondary-solid !text-heading dark:text-white btn-xl !rounded-full font-bold w-full h-12">
                                    {{ translate('Sign Up') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- JOIN AS ORGANIZATION -->
                <div class="dashkit-tab-pane" data-tab="asOrganization">
                    <form action="{{ route('auth.register') }}" method="POST" class="form">
                        @csrf
                        <input type="hidden" name="user_type" value="organization">
                        <div class="grid grid-cols-2 gap-x-3 gap-y-5">
                            <div class="col-span-full">
                                <div class="relative">
                                    <input type="text" id="org_name" name="name"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="org_name" class="form-label floating-form-label">{{ translate('Full Name') }} <span
                                            class="text-danger">*</span></label>
                                </div>
                                <span class="error-text name_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="email" id="org_email" name="email"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="org_email" class="form-label floating-form-label">{{ translate('Email') }} <span
                                            class="text-danger">*</span></label>
                                </div>
                                <span class="error-text email_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="text" id="org_phone" name="phone"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="org_phone" class="form-label floating-form-label">{{ translate('Phone') }} <span
                                            class="text-danger">*</span></label>
                                </div>
                                <span class="error-text phone_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="password" id="org_password" name="password"
                                        class="form-input rounded-full peer" placeholder="" />
                                    <label for="org_password" class="form-label floating-form-label">{{ translate('Password') }} <span
                                            class="text-danger">*</span></label>
                                    <!-- type toggler -->
                                    <label for="org_first_pass"
                                        class="size-8 rounded-full cursor-pointer flex-center hover:bg-gray-200 focus:bg-gray-200 absolute top-1/2 -translate-y-1/2 right-2 rtl:right-auto rtl:left-2">
                                        <input type="checkbox" id="org_first_pass" class="inputTypeToggle peer/it"
                                            hidden>
                                        <i
                                            class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                                    </label>
                                </div>
                                <span class="error-text password_err"></span>
                            </div>
                            <div class="col-span-full lg:col-auto">
                                <div class="relative">
                                    <input type="password" id="org_password_confirmation"
                                        name="password_confirmation" class="form-input rounded-full peer"
                                        placeholder="" />
                                    <label for="org_password_confirmation"
                                        class="form-label floating-form-label">{{ translate('Confirm Password') }} <span
                                            class="text-danger">*</span></label>
                                    <!-- type toggler -->
                                    <label for="org_confirm_pass"
                                        class="size-8 rounded-full cursor-pointer flex-center hover:bg-gray-200 focus:bg-gray-200 absolute top-1/2 -translate-y-1/2 right-2 rtl:right-auto rtl:left-2">
                                        <input type="checkbox" id="org_confirm_pass" class="inputTypeToggle peer/it"
                                            hidden>
                                        <i
                                            class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                                    </label>
                                </div>

                            </div>
                            <div class="col-span-full">
                                <div class="relative">
                                    <textarea id="org_address" name="address" rows="10" class="form-input rounded-2xl h-auto peer" placeholder=""></textarea>
                                    <label for="org_address" class="form-label floating-form-label">{{ translate('Address') }}</label>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <button type="submit" aria-label="Sign up"
                                    class="btn b-solid btn-secondary-solid !text-heading dark:text-white btn-xl !rounded-full font-bold w-full h-12">
                                    {{ translate('Sign Up') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div
                class="flex-center w-full max-w-screen-sm py-6 h-max relative text-heading dark:text-white font-normal before:absolute inset-0 before:w-full before:h-px before:bg-border">
                <span class="relative z-10 px-5 bg-white text-sm">{{ translate('OR') }}</span>
            </div>
            <div class="text-heading">
                {{ translate('Already have an account') }}?
                <a href="{{ route('login') }}" class="text-primary hover:underline" aria-label="Sign in page">{{ translate('Sign in') }}</a>
            </div>
        </div>
    </div>
</x-auth-layout>
