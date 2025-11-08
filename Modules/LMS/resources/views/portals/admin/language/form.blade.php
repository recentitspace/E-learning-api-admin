@php
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    $language = $language ?? null;
    if ($language && $locale) {
        $translations = parse_translation($language, $locale);
    }
@endphp


<x-dashboard-layout>
    <x-slot:title>{{ isset($language) ? translate('Edit') : translate('Create') }}
        {{ translate('Language') }}</x-slot:title>
    <!-- BREADCRUMB -->
    @if (is_active('language.translate') === 'active')
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
    <form action="{{ isset($language) ? route('language.update', $language->id) : route('language.store') }}"
        method="post" class="form">
        @if (isset($language))
            @method('put')
        @endif
        @csrf
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <div class="grid grid-cols-12 card mb-0">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label for="courseTitle" class="form-label">
                        {{ translate('Name') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" id="courseTitle" name="name"
                        value="{{ $translations['name'] ?? ($language->name ?? '') }}" class="form-input">
                    <span class="text-danger error-text name_err"></span>
                </div>
                @if (is_active('language.translate') == 'active')
                    <input type="hidden" id="code" name="code" value="{{ $language->code ?? '' }}"
                        class="form-input">
                    <span class="text-danger error-text code_err"></span>
                @endif
                @if (is_active('language.translate') !== 'active')
                    <div class="mt-6 leading-none">
                        <label for="code" class="form-label">
                            {{ translate('Short Code') }}
                            <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                        </label>
                        <input type="text" id="code" name="code" value="{{ $language->code ?? '' }}"
                            class="form-input">
                        <span class="text-danger error-text code_err"></span>
                    </div>
                @endif

                <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5">
                    {{ isset($language) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
