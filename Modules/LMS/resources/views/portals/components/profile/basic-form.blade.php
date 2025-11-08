@php

    $isOrganization = isOrganization();
    $isInstructor = isInstructor();
    $user = authCheck();

@endphp



<div class="fieldset !block">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="basic">
        @csrf
        <input type="hidden" name="id" value="{{ $user?->userable?->id ?? null }}">

        @if ($isOrganization)
            <input type="hidden" name="type" value="organization">
        @elseif ($isInstructor)
            <input type="hidden" name="type" value="instructor">
        @endif

        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6 card">
                @if (!$isOrganization)
                    <div class="">
                        <label for="firstName" class="form-label mb-2 d-block">
                            {{ translate('First Name') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="firstName" name="first_name"
                            placeholder="{{ translate('Enter First Name') }}"
                            value="{{ $user?->userable?->first_name }}" class="form-input" autocomplete="off">

                        <span class="text-danger error-text first_name_err"></span>
                    </div>
                    <div class="mt-6">
                        <label for="lastname" class="form-label mb-2 d-block"> {{ translate('Last Name') }} </label>

                        <input type="text" id="lastname" name="last_name"
                            placeholder="{{ translate('Enter Last Name') }}" class="form-input" autocomplete="off"
                            value="{{ $user?->userable?->last_name }}">
                        <span class="text-danger error-text last_name_err"></span>
                    </div>
                @else
                    <div class="mt-6">
                        <label for="name" class="form-label mb-2 d-block">
                            {{ translate('Organization Name') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="name" name="name"
                            placeholder="{{ translate('Enter Organization Name') }}"
                            value="{{ $user?->userable?->name }}" class="form-input" autocomplete="off">
                        <span class="text-danger error-text name_err"></span>
                    </div>
                @endif
                <div class="mt-6">
                    <label for="email" class="form-label mb-2 d-block">
                        {{ translate('Email') }} <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="email" name="email" placeholder="{{ translate('Enter Email') }}"
                        class="form-input" autocomplete="off" readonly value="{{ $user?->email ?? '' }}">

                </div>
                <div class="mt-6">
                    <label for="phone" class="form-label mb-2 d-block"> {{ translate('Phone') }} <span
                            class="text-danger">*</span></label>
                    <input type="text" id="phone" name="phone" placeholder="{{ translate('Enter Phone') }}"
                        class="form-input" autocomplete="off" value="{{ $user?->userable?->phone ?? '' }}">
                    <span class="text-danger error-text phone_err"></span>
                </div>
            </div>
            <div class="col-span-full lg:col-span-6 card">
                <div class="">
                    <label class="form-label mb-2 d-block"> {{ translate('Language') }} </label>
                    <select class="singleSelect" name="language_id">
                        <option selected disabled>{{ translate('Select Language') }}</option>
                        @foreach (get_all_language() as $language)
                            <option value="{{ $language->id }}"
                                {{ $user?->userable?->language_id == $language->id ? 'selected' : '' }}>
                                {{ $language->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-6">
                    <label class="form-label mb-2 d-block"> {{ translate('Time Zone') }}</label>
                    <select class="singleSelect" name="time_zone_id">
                        <option selected disabled> {{ translate('Select Time Zone') }} </option>
                        @foreach (get_all_zones() as $zone)
                            <option value="{{ $zone->id }}"
                                {{ $user?->userable?->time_zone_id == $zone->id ? 'selected' : '' }}>
                                {{ $zone->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-6">
                    <label for="password" class="form-label mb-2 d-block"> {{ translate('Password') }} <span
                            class="text-danger">*</span></label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            placeholder="{{ translate('Enter Password') }}" class="form-input" autocomplete="off">
                        <label for="toggle_password"
                            class="size-8 rounded-md flex-center hover:bg-gray-200 focus:bg-gray-200 position-center left-[calc(100%_-_24px)]">
                            <input type="checkbox" id="toggle_password" class="inputTypeToggle peer/it" hidden>
                            <i
                                class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                        </label>
                        <span class="text-danger error-text password_err"></span>
                    </div>
                </div>
                <div class="mt-6">
                    <label for="confirmation" class="form-label mb-2 d-block"> {{ translate('Confirm Password') }}
                        <span class="text-danger">*</span></label>
                    <div class="relative">
                        <input type="password" id="confirmation" name="password_confirmation"
                            placeholder="{{ translate('Confirm Password') }}" class="form-input" autocomplete="off">
                        <label for="toggle_confirm_password"
                            class="size-8 rounded-md flex-center hover:bg-gray-200 focus:bg-gray-200 position-center left-[calc(100%_-_24px)]">
                            <input type="checkbox" id="toggle_confirm_password" class="inputTypeToggle peer/it"
                                hidden>
                            <i
                                class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <label class="form-label d-block"> {{ translate('About Your self') }} </label>
            <textarea name="about" class="summernote form-input">{!! clean($user?->userable?->about ?? '') !!}</textarea>
        </div>
        <div class="card flex justify-end gap-2">
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }}
            </button>
        </div>
    </form>
</div>
