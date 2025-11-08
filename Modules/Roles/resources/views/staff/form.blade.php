@php
    $userPermissions = isset($userPermissions) && is_array($userPermissions) ? $userPermissions : [];
@endphp


<x-dashboard-layout>
    <x-slot:title>{{ isset($staff) ? translate('Edit') : translate('Create') }} {{ translate('Staff') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('staff.index') }}"
        title="{{ isset($staff) ? 'Edit' : 'Create' }} Staff" page-to="Staff" />
    <form action="{{ isset($staff) ? route('staff.update', $staff->id) : route('staff.store') }}" method="post"
        class="form">
        @if (isset($staff))
            @method('PUT')
        @endif
        @csrf
        <div class="grid grid-cols-12 gap-x-4">
            <input type="hidden" name="id" value="{{ $staff->id ?? '' }}">
            <div class="col-span-full md:col-span-8 card">
                <div class="grid grid-cols-2 gap-x-4 gap-y-6 mt-7">
                    <div class="col-span-full xl:col-auto leading-none">
                        <label class="form-label">{{ translate('Name') }} <span
                                class="require-field"><b>*</b></span></label>
                        <input type="text" name="name" value="{{ $staff->name ?? '' }}" class="form-input">
                        <span class="text-danger error-text name_err"></span>
                    </div>
                    <div class="col-span-full xl:col-auto leading-none">
                        <label class="form-label">{{ translate('Email') }} <span
                                class="require-field"><b>*</b></span></label>
                        <input type="text" name="email" value="{{ $staff->email ?? '' }}" class="form-input">
                        <span class="text-danger error-text email_err"></span>
                    </div>

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
                    <div class="col-span-full xl:col-auto leading-none">
                        <label class="form-label">{{ translate('Phone') }} <span
                                class="require-field"><b>*</b></span></label>
                        <input type="text" name="phone" value="{{ $staff->phone ?? '' }}" class="form-input">
                        <span class="text-danger error-text phone_err"></span>
                    </div>
                    <div class="col-span-full xl:col-auto leading-none">
                        <label class="form-label"> {{ translate('Roles') }}</label>
                        <select name="roles[]" class="singleSelect" multiple>
                            <option disabled>{{ translate('Select Role') }}</option>
                            @foreach (get_all_role() as $role)
                                <option value="{{ $role->name }}"
                                    @if (isset($staff->roles)) @foreach ($staff->roles as $srole)
                                            {{ $srole->name == $role->name ? 'selected' : '' }} 
                                        @endforeach @endif>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                </div>

                <div class="mt-5 mb-3">
                    <label class="text-lg"> {{ translate('Permission') }} </label>
                </div>
                <div class="h-80 overflow-y-scroll">

                    <div class="flex flex-col gap-5">
                        @foreach ($permissions as $key => $permission)
                            <div class="group-permission">
                                <div class="flex items-center gap-2 mb-2">
                                    <input id="check-s-{{ $key }}" type="checkbox"
                                        class="check check-primary-solid check-md check-enable-parent">
                                    <label for="check-s-{{ $key }}" class="card-title text-lg">
                                        {{ $key }}</label>
                                </div>
                                <div class="ml-10">
                                    @foreach ($permission as $value)
                                        <div class="flex items-center gap-2 mb-2">
                                            <input id="check-s-{{ $value->id }}" type="checkbox"
                                                class="check check-primary-solid check-md check-enable-child"
                                                name="permissions[]" value="{{ $value->name }}"
                                                {{ in_array($value->id, $userPermissions) ? 'checked' : '' }}>
                                            <label for="check-s-{{ $value->id }}"
                                                class="form-label text-base m-0">{{ $value->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
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
                            @if (isset($staff) && fileExists('lms/admins/', $staff?->profile_img) == true && $staff?->profile_img !== '')
                                <div class="img-thumb-wrapper"> <button class="remove">
                                        <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                    <img class="img-thumb" width="100"
                                        src="{{ asset('storage/lms/admins/' . $staff->profile_img) }}" />
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
                {{ isset($staff) ? translate('Update') : translate('Save') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
