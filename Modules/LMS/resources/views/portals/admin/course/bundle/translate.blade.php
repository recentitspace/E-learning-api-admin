@php
    $locale = request()->locale ?? app()->getLocale();
    $bundle = $bundle ?? null;

    if (!$bundle) {
        return;
    }
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ translate('Edit Bundle') }}</x-slot:title>
    <x-portal::admin.breadcrumb back-url="{{ route('bundle.index') }}" title="Edit" page-to="Bundle" />
    @if (is_active('bundle.translate') === 'active')
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
    <div class="mb-4">
        <div id="msform" class="*:hidden">
            <x-portal::course.bundle.basic-form :bundle=$bundle action="{{ route('bundle.store') }}"
                type="translations" />
        </div>
    </div>
    @push('js')
        <script src="{{ edulab_asset('lms/assets/js/component/stepper.js') }}"></script>
        <script src="{{ edulab_asset('lms/assets/js/bundle.js') }}"></script>
    @endpush
</x-dashboard-layout>
