@php
    $userInfo = $student->userable ?? null;
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    if ($userInfo) {
        $translations = parse_translation($userInfo, $locale);
    }
@endphp

<x-dashboard-layout>
    <x-slot:title> {{ translate('Edit Student') }} </x-slot:title>
    <x-portal::admin.breadcrumb back-url="{{ route('student.index') }}" title="Edit" page-to="Student" />

    @if (is_active('student.translate') === 'active')
    <div class="flex items-center justify-end gap-4 mb-2">
        <h2 class="card-title">{{ translate('Translate Language') }}</h2>
        <form method="GET" class="sm:block" id="change-translate-language">
            <select onchange="window.location.href=this.options[this.selectedIndex].value" name="id"
                class="text-gray-500 dark:text-dark-text dark:bg-dark-card-shade font-semibold bg-white focus:outline-none cursor-pointer select-none text-sm border dk-border-one px-2 py-2 rounded-md dk-theme-card-square">
                @foreach (app('languages') as $lang)
                    <option value="{{ $lang->code }}"
                        {{ isset($locale) && $locale == $lang->code ? 'selected' : '' }}>
                        {{ $lang->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    @endif

    <form action="{{ route('student.update', $student->id) }}" method="post" class="form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full {{ is_active('student.translate') !== 'active' ? 'lg:col-span-8' : '' }} card p-3 sm:p-6">
                <div class="p-1.5">
                    <h6 class="leading-none text-xl font-semibold text-heading"> {{ translate('Edit student') }} </h6>

                    <div class="grid grid-cols-2 gap-x-4 gap-y-6 mt-7">
                        <div class="col-span-full xl:col-auto leading-none">
                            <label for="name" class="form-label">
                                {{ translate('First Name') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <input type="text" id="name" name="first_name"
                                value="{{ $translations['first_name'] ?? $userInfo?->first_name ?? '' }}"
                                placeholder="{{ translate('Enter First Name') }}" class="form-input">
                            <span class="text-danger error-text first_name_err"></span>
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label for="last_name" class="form-label">
                                {{ translate('Last Name') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <input type="text" id="last_name" name="last_name"
                                value="{{ $translations['last_name'] ?? $userInfo?->last_name ?? '' }}"
                                placeholder="{{ translate('Enter Last Name') }}" class="form-input">
                            <span class="text-danger error-text last_name_err"></span>
                        </div>
                        @if (is_active('student.translate') !== 'active')
                        <div class="col-span-full xl:col-auto leading-none">
                            <label for="phone-number" class="form-label">
                                {{ translate('Phone Number') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <input type="text" id="phone-number" name="phone"
                                value="{{ $userInfo?->phone ?? '' }}"
                                placeholder="{{ translate('Enter Phone Number') }}" class="form-input">
                            <span class="text-danger error-text phone_err"></span>
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label for="email" class="form-label">
                                {{ translate('Email') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <input type="text" id="email" name="email" value="{{ $student?->email ?? '' }}"
                                placeholder="{{ translate('Enter Email') }}" class="form-input">
                            <span class="text-danger error-text email_err"></span>
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label for="password" class="form-label">
                                {{ translate('Country') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <select class="country-list form-input px-5 py-4 rounded-10 country-state"
                                name="country_id">
                                <option disabled selected>{{ translate('Select Country') }}</option>
                                @foreach (get_all_country() as $country)
                                    <option value="{{ $country->id }}"
                                        {{ $userInfo && $userInfo->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text country_id_err"></span>
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label for="state" class="form-label">
                                {{ translate('State') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <select class="state-list form-input px-5 py-4 rounded-10 state-city" id="stateOption"
                                name="state_id">
                                <option disabled selected>{{ translate('Select State') }}</option>
                            </select>
                            <span class="text-danger error-text state_id_err"></span>
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label for="city" class="form-label">
                                {{ translate('City') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <select class="city-list form-input px-5 py-4 rounded-10" id="cityOption" name="city_id">
                                <option disabled selected>{{ translate('Select City') }}</option>
                            </select>
                            <span class="text-danger error-text city_id_err"></span>
                        </div>
                        @endif
                        <div class="col-span-full xl:col-auto leading-none">
                            <label for="address" class="form-label">
                                {{ translate('Address') }}
                            </label>
                            <input type="text" id="address" name="address" value="{{ $translations['address'] ?? $userInfo?->address ?? '' }}"
                                placeholder="{{ translate('Enter Address') }}" class="form-input">
                            <span class="text-danger error-text address_err"></span>
                        </div>
                        <div class="col-span-full leading-none">
                            <label for="about" class="form-label">
                                {{ translate('About') }}
                            </label>
                            <textarea name="about" class="summernote" placeholder="{{ translate('Enter Details') }}">{{ clean($translations['about'] ?? $userInfo?->about ?? '') }}</textarea>
                        </div>
                    </div>

                </div>
            </div>
            @if (is_active('student.translate') !== 'active')
            <div class="col-span-full md:col-span-4 card p-3 sm:p-6">
                <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">

                <div class="col-span-full xl:col-auto leading-none mb-4">
                    <label class="form-label">
                        {{ translate('Password') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="password" name="password" placeholder="{{ translate('Enter Password') }}"
                        class="form-input">
                    <span class="text-danger error-text password_err"></span>
                </div>
                <div class="col-span-full xl:col-auto leading-none mb-4">
                    <label class="form-label">
                        {{ translate('Confirm Password') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="password" name="password_confirmation"
                        placeholder="{{ translate('Confirm Password') }}" class="form-input">
                </div>

                <p class="form-label">{{ translate('Profile Image') }}</p>
                <label for="imgage"
                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                    <input type="file" hidden name="image" id="imgage"
                        class="dropzone dropzone-image img-src peer/file">
                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                        <img src="{{ asset('lms/') }}/assets/images/icons/upload-file.svg" alt="file-icon"
                            class="size-8 lg:size-auto">
                        <div class="text-gray-500 dark:text-dark-text mt-2">{{ translate('Choose file') }}</div>
                    </span>
                    <span class="text-danger error-text image_err"></span>
                </label>
                <div class="preview-zone dropzone-preview">
                    <div class="box box-solid">
                        <div class="box-body flex items-center gap-2 flex-wrap">
                            @if (fileExists($folder = 'lms/students', $fileName = $userInfo?->profile_img) == true && $userInfo?->profile_img !== '')
                                <div class="img-thumb-wrapper"> <button class="remove">
                                        <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                    <img class="img-thumb" width="100"
                                        src="{{ asset('storage/lms/students/' . $userInfo?->profile_img) }}" />
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="card flex justify-end mb-5">
            <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                {{ translate('Update') }}
            </button>
        </div>
    </form>

    <input type="hidden" id="countryId" value="{{ $userInfo?->country_id }}" />
    <input type="hidden" id="stateId" value="{{ $userInfo?->state_id }}" />
    <input type="hidden" id="cityId" value="{{ $userInfo?->city_id }}" />
</x-dashboard-layout>
