@php
    $category = $category ?? null;
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    if ($category && $locale) {
        $translations = parse_translation($category, $locale);
    }
    $title = $translations['title'] ?? $category->title ?? '';
    $metaTitle = $translations['meta_title'] ?? $category->meta_title ?? '';
    $metaDescription = $translations['meta_description'] ?? $category->meta_description ?? '';
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ isset($category) ? translate('Edit') : translate('Create') }} {{ translate('Category') }}
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('category.index') }}"
        title="{{ isset($category) ? 'Edit' : 'Create' }}" page-to="Category" />

    @if (is_active('category.translate') === 'active')
        <div class="flex items-center justify-end gap-4 mb-2">
            <h2 class="card-title">{{ translate('Translate Language') }}</h2>
            <form method="GET" class="sm:block" id="change-translate-language">
                <select onchange="window.location.href=this.options[this.selectedIndex].value" name="id"
                    class="text-gray-500 dark:text-dark-text dark:bg-dark-card-shade font-semibold bg-white focus:outline-none cursor-pointer select-none text-sm border dk-border-one px-2 py-2 rounded-md dk-theme-card-square">
                    @foreach (app('languages') as $lang)
                        <option value="{{ $lang->code }}" {{ $locale == $lang->code ? 'selected' : '' }}>
                            {{ $lang->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    @endif

    <form action="{{ isset($category) ? route('category.update', $category->id) : route('category.store') }}"
        method="post" class="form mb-4" enctype="multipart/form-data">
        @csrf
        @if (isset($category))
            @method('PUT')
            <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        @endif
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6 card">
                <div class="leading-none">
                    <label for="title" class="form-label">
                        {{ translate('Title') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" id="title" name="title"
                        value="{{ $title }}" class="form-input">
                    <span class="text-danger error-text title_err"></span>
                </div>
                @if (is_active('category.edit') === 'active')
                    <div class="leading-none mt-6">
                        <label for="parent_id" class="form-label">{{ translate('Parent') }}</label>
                        <select data-select id="parent_id" name="parent_id" class="singleSelect">
                            <option selected disabled
                                data-display="{{ translate('Select none to create a parent category') }}">
                                {{ translate('Select none to create a parent category') }}
                            </option>
                            @foreach (get_all_category() as $pcat)
                                <option value="{{ $pcat->id }}"
                                    {{ isset($category) && $pcat->id == $category->parent_id ? 'selected' : '' }}>
                                    {{ $pcat->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="leading-none mt-6">
                        <label for="icon" class="form-label">{{ translate('Icon picker') }} </label>
                        <select data-select id="icon" name="icon_id" class="singleSelect">
                            <option selected disabled data-display="{{ translate('Selected Icon') }}">
                                {{ translate('Selected Icon') }}
                            </option>
                            @foreach (get_all_icon() as $icon)
                                <option value="{{ $icon->id }}"
                                    {{ isset($category) && $icon->id == $category->icon_id ? 'selected' : '' }}>
                                    {{ $icon->icon }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="leading-none mt-6">
                        <label for="order" class="form-label">
                            {{ translate('Category Position') }}
                        </label>
                        <input type="number" id="order" name="order" class="form-input"
                            placeholder="{{ translate('Enter Position') }}" value="{{ $category->order ?? null }}">
                    </div>
                @endif
                <div class="leading-none mt-6">
                    <label for="meta_title" class="form-label">
                        {{ translate('Meta Title') }}
                    </label>
                    <input type="text" id="meta_title" name="meta_title"
                        value="{{ $metaTitle }}" class="form-input"
                        placeholder="{{ translate('Enter Meta Title') }}">
                </div>
            </div>
            @if (is_active('category.edit') === 'active' || is_active('category.create') === 'active')
                <div class="col-span-full lg:col-span-6 card">
                    <label for="imgage"
                        class="dropzone-wrappe mb-4 file-container ac-bg text-xs leading-none font-semibold cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10">
                        <input type="file" hidden name="thumbnail" id="imgage"
                            class="dropzone dropzone-image img-src peer/file">
                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                            <img src="{{ asset('lms/') }}/assets/images/icons/upload-file.svg" alt="file-icon"
                                class="size-8 lg:size-auto">
                            <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }} </div>
                        </span>
                        <span class="text-danger error-text thumbnail_err"></span>
                    </label>
                    <div class="preview-zone dropzone-preview">
                        <div class="box box-solid">
                            <div class="box-body flex items-center gap-2 flex-wrap">
                                @if (isset($category) &&
                                        fileExists($folder = 'lms/categories', $fileName = $category->image) == true &&
                                        $category->image !== '')
                                    <div class="img-thumb-wrapper">
                                        <img class="img-thumb"
                                            src="{{ asset('storage/lms/categories/' . $category->image) }}"
                                            alt="">
                                    </div>
                                @else
                                    <div class="img-thumb-wrapper max-w-[120px] max-h-[120px]">
                                        <button class="remove text-danger">
                                            <i class="ri-close-line text-inherit text-[13px]"></i>
                                        </button>
                                        <img id="preview_img" width="auto" height="auto">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-span-full card">
                <label for="meta_description" class="form-label">
                    {{ translate('Meta Description') }}
                </label>
                <textarea name="meta_description" id="meta_description" class="summernote"> {!! clean($metaDescription) !!}</textarea>
            </div>
            <div class="col-span-full card flex justify-end">
                <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                    {{ isset($category) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
