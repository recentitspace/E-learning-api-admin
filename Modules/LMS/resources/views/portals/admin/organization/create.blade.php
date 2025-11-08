<x-dashboard-layout>
    <x-slot:title> {{ translate('Create Organization') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('organization.index') }}" title="Create" page-to="Organization" />
    <form action="{{ route('organization.store') }}" method="post" class="form" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-8 card">
                <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Add New Organization') }}</h6>
                <div class="grid grid-cols-2 gap-x-4 gap-y-6 mt-7">
                    <div class="col-span-full md:col-auto leading-none">
                        <label for="name" class="form-label">{{ translate('Name') }}
                            <span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                        <input type="text" id="name" name="name"
                            placeholder="{{ translate('Enter Organization Name') }}" class="form-input">
                        <span class="text-danger error-text name_err"></span>
                    </div>
                    <div class="col-span-full md:col-auto leading-none">
                        <label for="phone-number" class="form-label">
                            {{ translate('Phone Number') }}
                            <span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                        <input type="text" id="phone-number" name="phone"
                            placeholder="{{ translate('Enter Phone Number') }}" class="form-input">
                        <span class="text-danger error-text phone_err"></span>
                    </div>
                    <div class="col-span-full md:col-auto leading-none">
                        <label for="email" class="form-label">
                            {{ translate('Email') }}
                            <span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                        <input type="text" id="email" name="email"
                            placeholder="{{ translate('Enter Email') }}" class="form-input">
                        <span class="text-danger error-text email_err"></span>
                    </div>
                    <div class="col-span-full md:col-auto leading-none">
                        <label for="password" class="form-label">
                            {{ translate('Password') }}
                            <span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                        <input type="password" id="password" name="password"
                            placeholder="{{ translate('Enter Password') }}" class="form-input">
                        <span class="text-danger error-text password_err"></span>
                    </div>
                    <div class="col-span-full md:col-auto leading-none">
                        <label for="confirmation-password" class="form-label">
                            {{ translate('Confirmation Password') }}
                            <span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span>
                        </label>
                        <input type="password" id="confirmation-password" name="password_confirmation"
                            placeholder="{{ translate('Confirm Password') }}" class="form-input">
                    </div>
                    <div class="col-span-full md:col-auto leading-none">
                        <label for="password" class="form-label">
                            {{ translate('Country') }}
                        </label>
                        <select class="country-list form-input px-5 py-4 rounded-10 country-state" name="country_id">
                            <option disabled selected>{{ translate('Select country') }}</option>
                            @foreach (get_all_country() as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach

                        </select>
                        <span class="text-danger error-text country_id_err"></span>
                    </div>
                    <div class="col-span-full md:col-auto leading-none">
                        <label for="state" class="form-label">
                            {{ translate('State') }}
                            </span>
                        </label>
                        <select class="state-list form-input px-5 py-4 rounded-10 state-city" id="stateOption"
                            name="state_id">
                        </select>
                        <span class="text-danger error-text state_id_err"></span>
                    </div>


                    <div class="col-span-full md:col-auto leading-none">
                        <label for="city" class="form-label"> {{ translate('City') }} </label>
                        <select class="city-list form-input px-5 py-4 rounded-10" id="cityOption" name="city_id">
                            <option disabled selected></option>
                        </select>
                        <span class="text-danger error-text city_id_err"></span>
                    </div>

                    <div class="col-span-full leading-none">
                        <label for="address" class="form-label">
                            {{ translate('Address') }}
                        </label>
                        <input type="text" id="address" name="address"
                            placeholder="{{ translate('Enter address') }}" class="form-input">
                        <span class="text-danger error-text address_err"></span>
                    </div>
                    <div class="col-span-full">
                        <label for="address" class="form-label">
                            {{ translate('About') }}
                        </label>
                        <textarea name="about" class="summernote"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-span-full lg:col-span-4 card">
                <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                    {{ translate('Profile Image') }}({{ translate('100') }}x{{ translate('100') }})</p>
                <div>
                    <label for="imgage"
                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                        <input type="file" hidden name="image" id="imgage"
                            class="dropzone dropzone-image img-src peer/file">
                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                            <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}" alt="file-icon"
                                class="size-8 lg:size-auto">
                            <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }} </div>
                        </span>
                        <span class="text-danger error-text image_err"></span>
                    </label>
                    <div class="preview-zone dropzone-preview">
                        <div class="box box-solid">
                            <div class="box-body flex items-center gap-2 flex-wrap"></div>
                        </div>
                    </div>
                    <span class="text-danger error-text image_err"></span>
                </div>

                <div class="mt-7">
                    <label class="form-label"> {{ translate('Cover Image') }} </label>
                    <label
                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                        <input type="file" hidden name="profile_cover"
                            class="dropzone dropzone-image img-src peer/file">

                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                            <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}" alt="file-icon"
                                class="size-8 lg:size-auto">
                            <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }}
                            </div>
                        </span>
                    </label>
                    <div class="preview-zone dropzone-preview">
                        <div class="box box-solid">
                            <div class="box-body flex items-center gap-2 flex-wrap"></div>
                        </div>
                    </div>
                    <span class="text-danger error-text profile_cover_err"></span>
                </div>
            </div>
        </div>
        <div class="card flex justify-end">
            <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                {{ translate('Save') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
