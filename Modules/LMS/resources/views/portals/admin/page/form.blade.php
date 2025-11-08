@php
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    $page = $page ?? null;
    if ($page && $locale) {
        $translations = parse_translation($page, $locale);
    }
@endphp


<x-dashboard-layout>
    <x-slot:title> {{ translate('Edit Page') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('page.index') }}"
        title="{{ isset($page) ? 'Page Edit' : 'Page Create' }}" page-to=" Page" />


    @if (is_active('page.translate') === 'active')
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

    <form action="{{ route('page.update', $page->id) }}" method="post" class="form mb-4" enctype="multipart/form-data">
        @if (isset($page))
            @method('PATCH')
        @endif
        @csrf
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <div class="card">
            <div>
                <label for="title" class="form-label">{{ translate('Title') }} <span
                        class="require-field">*</span></label>
                <input type="text" id="title" name="title" placeholder="{{ translate('Enter Title') }}"
                    class="form-input" value="{{ $translations['title'] ?? ($page->title ?? '') }}">
                <span class="text-danger error-text title_err"></span>
            </div>
            <div class="mt-6">
                <label for="content" class="form-label"> {{ translate('Content') }} <span
                        class="require-field">*</span></label>
                <textarea name="content" class="summernote form-input">{!! clean($translations['content'] ?? ($page->content ?? '')) !!}</textarea>
                <span class="text-danger error-text content_err"></span>
            </div>
        </div>
        <div class="card flex justify-end">
            <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                {{ isset($page) ? translate('Update') : translate('Save') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
