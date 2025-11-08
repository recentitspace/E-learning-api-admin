<form id="course-request" action="{{ route('auth.register') }}" class="mt-6 form">
    @csrf
    <input type="hidden" name="user_type" value="instructor">
    <div class="grid grid-cols-2 gap-x-3 gap-y-4">
        <div class="col-span-full lg:col-auto">
            <div class="relative">
                <input type="text" id="user-first-name" name="first_name" class="form-input peer" placeholder="" />
                <label for="user-first-name" class="form-label floating-form-label">
                    {{ translate('First Name') }}</label>
            </div>
            <span class="text-danger text-center absolute error-text mt-1 d-block first_name_err"></span>
        </div>
        <div class="col-span-full lg:col-auto">
            <div class="relative">
                <input type="text" id="user-last-name" name="last_name" class="form-input peer" placeholder="" />
                <label for="user-last-name" class="form-label floating-form-label">
                    {{ translate('Last Name') }}</label>
            </div>
            <span class="text-danger text-center absolute error-text mt-1 d-block last_name_err"></span>
        </div>
        <div class="col-span-full lg:col-auto">
            <div class="relative">
                <input type="email" id="user-email" name="email" class="form-input peer" placeholder="" />
                <label for="user-email" class="form-label floating-form-label"> {{ translate('Email') }} </label>
            </div>
            <span class="text-danger text-center absolute error-text mt-1 d-block email_err"></span>
        </div>

        <div class="col-span-full lg:col-auto">
            <div class="relative">
                <input type="text" id="password" name="password" class="form-input peer" placeholder="" />
                <label for="password" class="form-label floating-form-label">
                    {{ translate('Password') }}
                </label>
            </div>
            <span class="text-danger text-center absolute error-text mt-1 d-block password_err"></span>
        </div>
        <div class="col-span-full lg:col-auto">
            <div class="relative">
                <input type="text" id="password-confirmation" name="password_confirmation"
                    class="form-input form-input peer" placeholder="" />
                <label for="password-confirmation" class="form-label floating-form-label">
                    {{ translate('Confirm Password') }}
                </label>
            </div>
            <span class="text-danger text-center absolute error-text mt-1 d-block password_confirmation_err"></span>
        </div>
        <div class="col-span-full lg:col-auto">
            <div class="relative">
                <input type="text" id="designation" name="designation" class="form-input  peer" placeholder="" />
                <label for="designation" class="form-label floating-form-label">
                    {{ translate('Designation') }}
                </label>
            </div>
            <span class="text-danger text-center absolute error-text mt-1 d-block designation_err"></span>
        </div>
        <div class="col-span-full">
            <div class="relative">
                <input type="text" id="user-address" name="address" class="form-input peer" placeholder="" />
                <label for="user-address"
                    class="form-label floating-form-label">{{ translate('Street Address') }}</label>
            </div>
        </div>
        <div class="col-span-full">
            <div class="relative">
                <textarea id="user-education" rows="5" name="about" class="form-input rounded-2xl h-auto peer" placeholder=""></textarea>
                <label for="user-education"
                    class="form-label floating-form-label">{{ translate('Write Description') }}</label>
            </div>
        </div>
        <div class="col-span-full">
            <button type="submit" aria-label="join as Instructor" class="btn b-solid btn-primary-solid !text-heading font-bold w-full">
                {{ translate('join as Instructor') }}
            </button>
        </div>
    </div>
</form>
