@php
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    $instructor = $instructor ?? null;
    if ($instructor?->userable && $locale) {
        $translations = parse_translation($instructor?->userable, $locale);
    }
@endphp



<x-dashboard-layout>
    <x-slot:title>{{ translate('Edit Instructor') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Edit" back-url="{{ route('organization.instructor.index') }}"
        page-to="Instructor" />

    @if (is_active('organization.instructor.translate') === 'active')
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

    <x-portal::instructor.create action="{{ route('organization.instructor.update', $instructor->id) }}"
        :instructor=$instructor :translations="$translations" :locale="$locale" />

    <input type="hidden" id="countryId" value="{{ $instructor?->userable?->country_id }}" />
    <input type="hidden" id="stateId" value="{{ $instructor?->userable?->state_id }}" />
    <input type="hidden" id="cityId" value="{{ $instructor?->userable?->city_id }}" />
</x-dashboard-layout>
