@php
$locale = request()->locale ?? app()->getLocale();
$translations = [];
$level = $level ?? null;
if ($level && $locale) {
    $translations = parse_translation($level, $locale);
}
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ isset($level) ? translate('Edit') : translate('Create') }} {{ translate('Level') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="{{ isset($level) ? 'Edit' : 'Create' }}" page-to="Level"
        back-url="{{ route('level.index') }}" />
    @if (is_active('level.translate') === 'active')
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
    <form action="{{ isset($level) ? route('level.update', $level->id) : route('level.store') }}" method="post"
        class="form" enctype="multipart/form-data">

        @if (isset($level))
            @method('PUT')
        @endif
        @csrf
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <div class="grid grid-cols-12 card">
            <div class="col-span-full md:col-span-6">
                <div>
                    <label for="name" class="form-label">{{ translate('Name') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ $translations['name'] ?? $level->name ?? '' }}"
                        class="form-input">
                    <span class="text-danger error-text name_err"></span>
                </div>
                <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5 dk-theme-card-square">
                    {{ isset($level) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
