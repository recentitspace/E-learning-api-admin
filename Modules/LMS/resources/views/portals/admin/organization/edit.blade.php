@php
    $userInfo = $organization?->userable ?? null;
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    if ($userInfo) {
        $translations = parse_translation($userInfo, $locale);
    }
@endphp

<x-dashboard-layout>
    <x-slot:title> {{ translate('Edit Organization') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('organization.index') }}" title="Edit" page-to="Organization" />

    @if (is_active('organization.translate') === 'active')
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

    <form action="{{ route('organization.update', $organization->id) }}" method="post" class="form"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full {{ is_active('organization.translate') !== 'active' ? 'lg:col-span-8' : '' }} card p-4 md:p-6">
                <h6 class="leading-none text-xl font-semibold text-heading"> {{ translate('Edit Organization') }} </h6>
                <div class="grid grid-cols-2 gap-x-4 gap-y-6 mt-7">
                    <div class="col-span-full md:col-auto leading-none">
                        <label for="name" class="form-label"> {{ translate('Organization Name') }}
                            <span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                        <input type="text" id="name" name="name"
                            value="{{ $translations['name'] ?? $organization?->userable?->name ?? '' }}"
                            placeholder="{{ translate('Enter Organization Name') }}" class="form-input">
                        <span class="text-danger error-text name_err"></span>
                    </div>
                    @if (is_active('organization.translate') !== 'active')
                    <div class="col-span-full md:col-auto leading-none">
                        <label for="phone-number" class="form-label"> {{ translate('Phone Number') }}
                            <span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                        <input type="text" id="phone-number" name="phone"
                            value="{{ $organization?->userable?->phone }}"
                            placeholder="{{ translate('Enter Phone Number') }}" class="form-input">
                        <span class="text-danger error-text phone_err"></span>
                    </div>
                    <div class="col-span-full md:col-auto leading-none">
                        <label for="email" class="form-label">
                            {{ translate('Email') }}
                            <span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                        <input type="text" id="email" name="email"
                            placeholder="{{ translate('Enter Email') }}" class="form-input"
                            value="{{ $organization?->email }}">
                        <span class="text-danger error-text email_err"></span>
                    </div>
                    <div class="col-span-full md:col-auto leading-none">
                        <label for="password" class="form-label"> {{ translate('Country') }}
                        </label>
                        <select class="country-list form-input px-5 py-4 rounded-10 country-state" name="country_id">
                            <option disabled selected></option>
                            @foreach (get_all_country() as $country)
                                <option value="{{ $country->id }}"
                                    {{ $userInfo && $userInfo->country_id == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}</option>
                            @endforeach

                        </select>
                        <span class="text-danger error-text country_id_err"></span>
                    </div>
                    <div class="col-span-full md:col-auto leading-none">
                        <label for="state" class="form-label"> {{ translate('State') }} </label>
                        <select class="state-list form-input px-5 py-4 rounded-10 state-city" id="stateOption"
                            name="state_id">
                            <option disabled selected></option>
                        </select>
                        <span class="text-danger error-text state_id_err"></span>
                    </div>


                    <div class="col-span-full md:col-auto leading-none">
                        <label for="city" class="form-label"> {{ translate('city') }} </label>
                        <select class="city-list form-input px-5 py-4 rounded-10" id="cityOption" name="city_id">
                            <option disabled selected></option>
                        </select>
                        <span class="text-danger error-text city_id_err"></span>
                    </div>
                    @endif

                    <div class="col-span-full">
                        <label for="address" class="form-label"> {{ translate('Address') }}
                        </label>
                        <input type="text" id="address" name="address"
                            value="{{ $translations['address'] ?? $organization?->userable?->address ?? '' }}" class="form-input">
                        <span class="text-danger error-text address_err"></span>
                    </div>
                    <div class="col-span-full leading-none">
                        <label for="address" class="form-label"> {{ translate('About') }}
                        </label>
                        <textarea name="about" class="summernote">{!! clean($translations['about'] ?? $organization?->userable?->about ?? '') !!}</textarea>
                    </div>
                </div>
            </div>
            @if (is_active('organization.translate') !== 'active')
            <div class="col-span-full lg:col-span-4 card p-4 md:p-6">
                <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                <div class="mb-3">
                    <h1>{{ translate('Change Password') }}</h1>
                </div>
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
                <div>
                    <label class="form-label"> {{ translate('Profile Image') }}({{ translate('100') }}x{{ translate('100') }})</p> </label>
                    <label for="imgage"
                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                        <input type="file" hidden name="image" id="imgage"
                            class="dropzone dropzone-image img-src peer/file">
                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                            <img src="{{ asset('lms/') }}/assets/images/icons/upload-file.svg" alt="file-icon"
                                class="size-8 lg:size-auto">
                            <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }} </div>
                        </span>
                        <span class="text-danger error-text image_err"></span>
                    </label>
                    <div class="preview-zone dropzone-preview">
                        <div class="box box-solid">
                            <div class="box-body flex items-center gap-2 flex-wrap">

                                @if (fileExists($folder = 'lms/organizations', $fileName = $organization?->userable?->profile_img) == true &&
                                        $organization?->userable?->profile_img !== '')
                                    <div class="img-thumb-wrapper"> <button class="remove">
                                            <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                        <img class="img-thumb" width="100"
                                            src="{{ asset('storage/lms/organizations/' . $organization?->userable?->profile_img) }}" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <div class="mt-7">
                    <label class="form-label"> {{ translate('Cover Image') }} </label>
                    <label
                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                        <input type="file" hidden name="profile_cover"
                            class="dropzone dropzone-image img-src peer/file">

                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                            <img src="{{ asset('lms/') }}/assets/images/icons/upload-file.svg" alt="file-icon"
                                class="size-8 lg:size-auto">
                            <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }}
                            </div>
                        </span>

                    </label>
                    <div class="preview-zone dropzone-preview">
                        <div class="box box-solid">
                            <div class="box-body flex items-center gap-2 flex-wrap">
                                @if (fileExists('lms/organizations', $fileName = $organization?->userable?->cover_photo) == true &&
                                        $organization?->userable?->cover_photo !== '')
                                    <div class="img-thumb-wrapper"> <button class="remove text-danger">
                                            <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                        <img class="img-thumb" width="100"
                                            src="{{ asset('storage/lms/organizations/' . $organization?->userable?->cover_photo) }}" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="text-danger error-text profile_cover_err"></span>
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
    <input type="hidden" id="countryId" value="{{ $organization?->userable?->country_id }}" />
    <input type="hidden" id="stateId" value="{{ $organization?->userable?->state_id }}" />
    <input type="hidden" id="cityId" value="{{ $organization?->userable?->city_id }}" />
</x-dashboard-layout>
