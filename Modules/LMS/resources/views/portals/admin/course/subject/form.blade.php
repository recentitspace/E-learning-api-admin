@php
$locale = request()->locale ?? app()->getLocale();
$translations = [];
$subject = $subject ?? null;
if ($subject && $locale) {
    $translations = parse_translation($subject, $locale);
}
$name = $translations['name'] ?? $subject->name ?? '';
$metaTitle = $translations['meta_title'] ?? $subject->meta_title ?? '';
$metaDescription = $translations['meta_description'] ?? $subject->meta_description ?? '';
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ isset($subject) ? translate('Edit') : translate('Create') }} {{ translate('Subject') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('subject.index') }}" title="{{ isset($subject) ? 'Edit' : 'Create' }}"
        page-to="Subject" />
    @if (is_active('subject.translate') === 'active')
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
    <form action="{{ isset($subject) ? route('subject.update', $subject->id) : route('subject.store') }}" method="post"
        class="form" enctype="multipart/form-data">
        @if (isset($subject))
            @method('PUT')
        @endif
        @csrf
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full md:col-span-8">
                <div class="card">
                    <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                        <div class="col-span-full xl:col-auto leading-none">
                            <label for="courseTitle" class="form-label"> {{ translate('Name') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <input type="text" id="courseTitle" name="name" value="{{ $name }}"
                                class="form-input">
                            <span class="text-danger error-text name_err"></span>
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label for="meta_title" class="form-label">
                                {{ translate('Meta Title') }}
                            </label>
                            <input type="text" id="meta_title" name="meta_title"
                                value="{{ $metaTitle }}" class="form-input">
                        </div>
                        <div class="col-span-full">
                            <label for="courseType" class="form-label">
                                {{ translate('Meta Description') }}
                            </label>
                            <div>
                                <textarea id="description" name="meta_description" class="summernote" rows="8"
                                    class="w-full text-gray-500 dark:text-dark-text p-2.5 border border-input-border rounded-10 focus:outline-primary-400">
                                    {!! clean($metaDescription) !!}
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-full md:col-span-4 card">
                @if (is_active('subject.translate') !== 'active')
                <label class="form-label">
                    {{ translate('Subject thumbnail') }}
                    <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                </label>
                <label for="thumbnail"
                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                    <input type="file" hidden name="thumbnail" id="thumbnail"
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
                            @if (isset($subject) &&
                                    fileExists($folder = 'lms/subjects', $fileName = $subject->image) == true &&
                                    $subject->image !== '')
                                <div class="img-thumb-wrapper">
                                    <img class="img-thumb"
                                        src="{{ asset('storage/lms/subjects/' . $subject->image) }}" />
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
                @endif
                <div class="flex justify-end">
                    <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5 dk-theme-card-square">
                        {{ isset($subject) ? translate('Update') : translate('Save') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-dashboard-layout>
