@php
    $auth = auth('admin')->user();
@endphp
<x-dashboard-layout>
    <x-slot:title> {{ translate('Profile Update') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <form action="{{ route('admin.profile.update') }}" method="post" class="form">
        @csrf
        <div class="grid grid-cols-12 gap-x-4">
            <input type="hidden" name="id" value="{{ $auth->id ?? '' }}">
            <div class="col-span-full md:col-span-8 card">
                <div class="grid grid-cols-2 gap-x-4 gap-y-6 mt-7">
                    <div class="col-span-full xl:col-auto leading-none">
                        <label class="form-label">{{ translate('Name') }} <span
                                class="require-field"><b>*</b></span></label>
                        <input type="text" name="name" value="{{ $auth->name ?? '' }}" class="form-input">
                        <span class="text-danger error-text name_err"></span>
                    </div>
                    <div class="col-span-full xl:col-auto leading-none">
                        <label class="form-label">{{ translate('Email') }} <span
                                class="require-field"><b>*</b></span></label>
                        <input type="text" name="email" value="{{ $auth->email ?? '' }}" class="form-input">
                        <span class="text-danger error-text email_err"></span>
                    </div>
                    <div class="col-span-full xl:col-auto leading-none">
                        <label class="form-label">{{ translate('Phone') }} <span
                                class="require-field"><b>*</b></span></label>
                        <input type="text" name="phone" value="{{ $auth->phone ?? '' }}" class="form-input">
                        <span class="text-danger error-text phone_err"></span>
                    </div>
                </div>
                <label class="form-label mt-7"> <b>{{ translate('Change Password') }}</b></label>
                <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                    <div class="col-span-full xl:col-auto leading-none">
                        <label class="form-label">{{ translate('Password') }} <span
                                class="require-field"><b>*</b></span></label>
                        <input type="password" name="password" class="form-input">
                        <span class="text-danger error-text password_err"></span>
                    </div>

                    <div class="col-span-full xl:col-auto leading-none">
                        <label class="form-label">{{ translate('Confirm Password') }} <span
                                class="require-field"><b>*</b></span></label>
                        <input type="password" name="password_confirmation" class="form-input">
                    </div>
                </div>
            </div>
            <div class="col-span-full md:col-span-4 card">
                <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                    {{ translate('Profile Image') }}(100x100)
                </p>
                <label for="profileImg"
                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                    <input type="file" hidden name="image" id="profileImg"
                        class="dropzone dropzone-image img-src peer/file">

                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                        <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}" alt="file-icon"
                            class="size-8 lg:size-auto">
                        <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }}</div>
                    </span>
                </label>
                <div class="preview-zone dropzone-preview">
                    <div class="box box-solid">
                        <div class="box-body flex items-center gap-2 flex-wrap">
                            @if (isset($auth) && fileExists('lms/admins/', $auth?->profile_img) == true && $auth?->profile_img !== '')
                                <div class="img-thumb-wrapper"> <button class="remove">
                                        <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                    <img class="img-thumb" width="100"
                                        src="{{ asset('storage/lms/admins/' . $auth->profile_img) }}" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <span class="text-danger error-text image_err"></span>
            </div>
        </div>
        <div class="card flex justify-end">
            <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Update') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
