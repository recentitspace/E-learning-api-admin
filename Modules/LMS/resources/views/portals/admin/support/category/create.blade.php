@php
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    $supportCategory = $supportCategory ?? null;
    if ($supportCategory && $locale) {
        $translations = parse_translation($supportCategory, $locale);
    }
@endphp

<x-dashboard-layout>
    <x-slot:title> {{ translate('support-category/create') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('support-ticket.category.index') }}"
        title="{{ isset($supportCategory) ? 'Edit' : 'Create' }} Support Category" page-to="Support" />

    @if (is_active('support-ticket.category.translate') === 'active')
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

    <form method="post" class="form"
        action="{{ isset($supportCategory) ? route('support-ticket.category.update', $supportCategory->id) : route('support-ticket.category.store') }}">
        @csrf
        @if (isset($supportCategory))
            @method('PUT')
            <input type="hidden" name="id" value="{{ $supportCategory->id }}">
        @endif
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">

        <div class="card">
            <label for="forumTitle" class="form-label">{{ translate('Name') }} <span class="text-danger"> *</span>
            </label>
            <input type="text" id="forumName" placeholder="{{ translate('Name') }}" name="name"
                value="{{ $translations['name'] ?? ($supportCategory->name ?? '') }}" class="form-input">
            <span class="text-danger error-text name_err"></span>
        </div>
        <div class="flex justify-end card">
            <button type="submit" class="btn b-solid btn-primary-solid px-5 dk-theme-card-square">
                {{ translate('Submit') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
