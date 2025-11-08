@php
    $country = $country ?? null;
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    if ($country && $locale) {
        $translations = parse_translation($country, $locale);
    }
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ isset($country) ? translate('Edit') : translate('Create') }}
        {{ translate('Country') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('country.index') }}" title="{{ isset($country) ? 'Edit' : 'Create' }}"
        page-to="Country" />

    @if (is_active('country.translate') === 'active')
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

    <form action="{{ isset($country) ? route('country.update', $country->id) : route('country.store') }}" method="post"
        class="form">

        @if (isset($country))
            @method('put')
        @endif
        @csrf
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <div class="grid grid-cols-12 card mb-0">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label for="name" class="form-label">
                        {{ translate('Name') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ $translations['name'] ?? $country->name ?? '' }}"
                        class="form-input">
                    <span class="text-danger error-text name_err"></span>
                </div>
                <div class="mt-6 leading-none">
                    <label for="code" class="form-label">
                        {{ translate('Country Code') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" id="code" name="code" value="{{ $country->code ?? '' }}"
                        class="form-input">
                    <span class="text-danger error-text code_err"></span>
                </div>
                <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5 dk-theme-card-square">
                    {{ isset($country) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
