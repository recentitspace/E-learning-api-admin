<x-dashboard-layout>
    <x-slot:title>{{ translate('Create City') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('city.index') }}" title="Create" page-to="City" />
    <form action="{{ route('city.store') }}" method="post" class="form">
        @csrf
        <div class="grid grid-cols-12 card mb-0">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label for="courseTitle" class="form-label">{{ translate('Country') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select data-select name="country_id" class="singleSelect country-state">
                        <option selected disabled data-display="{{ translate('Selected Country') }}">
                            {{ translate('Select Country') }}
                        </option>
                        @foreach (get_all_country() as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text country_id_err"></span>
                </div>
                <div class="mt-6 leading-none">
                    <label for="courseTitle" class="form-label"> {{ translate('State') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select data-select id="stateOption" name="state_id" class="singleSelect ">
                        <option selected disabled data-display="{{ translate('Selected State') }}">
                            {{ translate('Select State') }}
                        </option>
                    </select>
                    <span class="text-danger error-text state_id_err"></span>
                </div>
                <div class="mt-6 leading-none">
                    <label for="courseTitle" class="form-label">{{ translate('Name') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" id="courseTitle" name="name" placeholder="{{ translate('City Name') }}"
                        class="form-input">
                    <span class="text-danger error-text name_err"></span>
                </div>
                <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5 dk-theme-card-square">
                    {{ translate('Save') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
