@php
    $inputClass = isset($formType) && $formType == 'support' ? '!bg-white ' : '';
    $formClass = $class ?? 'mt-6 form ';
@endphp

<form action="{{ route('contact.store') }}" class="{{ $formClass }} form" method="post">
    @csrf
    @isset($userId)
        <input type="hidden" id="user-first-name" name="user_id" class="form-input rounded-full peer"
            value="{{ $userId }}" />
    @endisset
    <div class="grid grid-cols-2 gap-x-3 gap-y-4">
        <div class="col-span-full lg:col-auto">
            <div class="relative">
                <input type="text" id="user-first-name" name="name"
                    class="form-input rounded-full peer  {{ $inputClass }}" placeholder="" />
                <label for="user-first-name" class="form-label floating-form-label">
                    {{ translate('Full Name') }}
                    <span class="text-danger">*</span>
                </label>
            </div>
            <span class="text-danger error-text name_err"></span>
        </div>


        <div class="col-span-full lg:col-auto">
            <div class="relative">
                <input type="email" id="user-email" name="email"
                    class="form-input rounded-full peer {{ $inputClass }}" placeholder="" />
                <label for="user-email" class="form-label floating-form-label">
                    {{ translate('Email') }}
                    <span class="text-danger">*</span>
                </label>
            </div>
            <span class="text-danger error-text email_err"></span>
        </div>
        <div class="col-span-full lg:col-auto">
            <div class="relative">
                <input type="text" id="user-phone" name="phone"
                    class="form-input rounded-full peer {{ $inputClass }}" placeholder="" />
                <label for="user-phone" class="form-label floating-form-label">
                    {{ translate('Phone') }}
                    <span class="text-danger">*</span>
                </label>
            </div>
            <span class="text-danger error-text phone_err"></span>
        </div>
        <div class="col-span-full lg:col-auto">
            <div class="relative">
                <input type="text" id="user-address" class="form-input rounded-full peer {{ $inputClass }}"
                    name="subject" placeholder="" />
                <label for="user-address" class="form-label floating-form-label">
                    {{ translate('Subject') }}
                    <span class="text-danger">*</span>
                </label>
            </div>
            <span class="text-danger error-text subject_err"></span>
        </div>
        <div class="col-span-full">
            <div class="relative">
                <textarea id="user-education" rows="10" class="form-input rounded-2xl h-auto peer !bg-white" name="message"
                    placeholder=""></textarea>
                <label for="user-education" class="form-label floating-form-label">
                    {{ translate('Write your message') }}
                    <span class="text-danger">*</span>
                </label>
            </div>
            <span class="text-danger error-text message_err"></span>
        </div>
        <div class="col-span-full">
            <button type="submit" class="btn b-solid btn-primary-solid btn-xl h-12 !rounded-full"
                aria-label="Send now">
                {{ translate('Send Now') }}
                <span class="hidden md:block">
                    <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                </span>
            </button>
        </div>
    </div>
</form>
