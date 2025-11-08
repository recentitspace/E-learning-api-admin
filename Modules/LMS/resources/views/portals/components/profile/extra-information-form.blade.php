@php
    $user = authCheck();
@endphp

<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="extra-information">
        @csrf
        <input type="hidden" name="id" value="{{ $user?->userable?->id }}">
        <input type="hidden" name="user_id" value="{{ $user?->id }}">
        <div class="grid grid-cols-12 gap-6 card">
            <div class="col-span-full lg:col-span-6 leading-none">
                <label for="country" class="form-label">{{ translate('Country') }}</label>
                <select class="singleSelect country-state" name="country_id">
                    <option selected disabled>{{ translate('Select Country') }}</option>
                    @foreach (get_all_country() as $country)
                        <option value="{{ $country->id }}"
                            {{ $user?->userable?->country_id == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-full lg:col-span-6 leading-none">
                <label for="state" class="form-label"> {{ translate('State') }} </label>
                <select class="singleSelect state-city" id="stateOption" name="state_id">
                    <option selected disabled> {{ translate('Select State') }} </option>
                </select>
            </div>
            <div class="col-span-full lg:col-span-6 leading-none">
                <label for="city" class="form-label">{{ translate('City') }}</label>
                <select class="city-list" id="cityOption" name="city_id">
                    <option selected disabled> {{ translate('Select City') }} </option>
                </select>
            </div>
            <div class="col-span-full lg:col-span-6 leading-none">
                <label for="address" class="form-label"> {{ translate('Address') }} </label>
                <input type="text" id="address" placeholder="{{ translate('Address') }}" name="address"
                    class="form-input" autocomplete="off" value="{{ $user?->userable?->address }}">
            </div>
            @if (!isOrganization())
                <div class="col-span-full lg:col-span-6 leading-none">
                    <label for="age" class="form-label"> {{ translate('Age') }} </label>
                    <input type="number" id="age" name="age" placeholder="{{ translate('Age') }}"
                        class="form-input" autocomplete="off" value="{{ $user?->userable?->age }}">
                </div>
                <div class="col-span-full">
                    <h6 class="text-sm font-medium text-gray-500 dark:text-dark-text mb-1"> {{ translate('Gender') }}
                    </h6>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <input type="radio" name="gender" id="male"
                                {{ $user?->userable?->gender == 'male' ? 'checked' : '' }} value="male"
                                class="radio radio-primary">
                            <label for="male" class="form-label mb-0 leading-none"> {{ translate('Male') }}
                            </label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="radio" name="gender" id="female" value="female"
                                class="radio radio-primary"
                                {{ $user?->userable?->gender == 'female' ? 'checked' : '' }}>
                            <label for="female" class="form-label mb-0 leading-none"> {{ translate('Female') }}
                            </label>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="card flex justify-end gap-4">
            <button type="button" class="prev-form-btn btn b-outline btn-primary-outline"> {{ translate('Previous') }}
            </button>
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }} </button>
        </div>
    </form>
</div>
