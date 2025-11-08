@php
    $city = $city ?? null;
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    if ($city && $locale) {
        $translations = parse_translation($city, $locale);
    }
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ translate('Edit City') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('city.index') }}" title="Edit" page-to="City" />

    @if (is_active('city.translate') === 'active')
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

    <form action="{{ route('city.update', $city->id) }}" method="post" class="form">
        @method('put')
        @csrf
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <div class="grid grid-cols-12 card mb-0">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label class="form-label">
                        {{ translate('Country') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select data-select name="country_id" class="singleSelect country-state">
                        <option selected disabled data-display="{{ translate('Selected Country') }}">
                            {{ translate('Selected Country') }}
                        </option>
                        @foreach (get_all_country() as $country)
                            @php $countryTranslations = parse_translation($country, $locale); @endphp
                            <option value="{{ $country->id }}"
                                {{ $country->id == $city->country_id ? 'selected' : '' }}>{{ $countryTranslations['name'] ?? $country->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text country_id_err"></span>
                </div>
                <div class="mt-6 leading-none">
                    <label class="form-label">
                        {{ translate('State') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select id="stateOption" name="state_id" class="singleSelect state-city">
                        <option disabled data-display="{{ translate('Select State') }}"> {{ translate('Select State') }} </option>
                    </select>
                    <span class="text-danger error-text state_id_err"></span>
                </div>
                <div class="mt-6 leading-none">
                    <label class="form-label">{{ translate('Name') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" id="courseTitle" name="name" value="{{ $translations['name'] ?? $city->name ?? '' }}"
                        class="form-input">
                    <span class="text-danger error-text name_err"></span>
                </div>
                <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5 dk-theme-card-square">
                    {{ translate('Update') }}
                </button>
            </div>
        </div>
    </form>

    <input type="hidden" id="countryId" value="{{ $city->country_id }}">
    <input type="hidden" id="stateId" value="{{ $city?->state?->id }}" />
</x-dashboard-layout>
