@php
    $state = $state ?? null;
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    if ($state && $locale) {
        $translations = parse_translation($state, $locale);
    }
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ isset($state) ? translate('Edit') : translate('Create') }} {{ translate('State') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('state.index') }}" title="{{ isset($state) ? 'Edit' : 'Create' }}"
        page-to="State" />

    @if (is_active('state.translate') === 'active')
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

    <form action="{{ isset($state) ? route('state.update', $state->id) : route('state.store') }}" method="post"
        class="form">
        @if (isset($state))
            @method('put')
        @endif
        @csrf
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <div class="grid grid-cols-12 card mb-0">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label for="courseTitle" class="form-label"> {{ translate('Country') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select data-select name="country_id" class="singleSelect">
                        <option selected disabled data-display="{{ translate('Select Country') }}">
                            {{ translate('Select Country') }}
                        </option>
                        @foreach (get_all_country() as $country)
                            @php $countryTranslations = parse_translation($country, $locale); @endphp
                            <option value="{{ $country->id }}"
                                {{ isset($state) && $country->id == $state->country_id ? 'selected' : '' }}>
                                {{ $countryTranslations['name'] ?? $country->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text country_id_err"></span>
                </div>
                <div class="mt-6 leading-none">
                    <label for="courseTitle" class="form-label">{{ translate('Name') }}
                        <span class="text-danger"
                            title="{{ translate('This field is required') }}"><b>*</b></span></label>
                    <input type="text" id="courseTitle" name="name" value="{{ $translations['name'] ?? $state->name ?? '' }}"
                        class="form-input">
                    <span class="text-danger error-text name_err"></span>

                </div>
                <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5 dk-theme-card-square">
                    {{ isset($state) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
