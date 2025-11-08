@php
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    $blog = $blog ?? null;
    if ($blog && $locale) {
        $translations = parse_translation($blog, $locale);
    }
@endphp

<x-dashboard-layout>
    <x-slot:title>
        {{ isset($blog) ? translate('Edit Blog') : translate('Create Blog') }}
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('blog.index') }}" title="{{ isset($blog) ? 'Edit' : 'Create' }}"
        page-to="Blog" />

    @if (is_active('blog.translate') === 'active')
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
    <form action="{{ isset($blog) ? route('blog.update', $blog->id) : route('blog.store') }}" method="post"
        class="form" enctype="multipart/form-data">
        @if (isset($blog))
            @method('PUT')
        @endif
        @csrf
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full md:col-span-7 card">
                <div>
                    <label for="blog-title" class="form-label">{{ translate('Blog Title') }} <span
                            class="text-danger">*</span> </label>
                    <input type="text" id="blog-title" placeholder="{{ translate('Title') }}" name="title"
                        class="form-input" autocomplete="off"
                        value="{{ $translations['title'] ?? ($blog->title ?? '') }}">
                    <span class="text-danger error-text title_err"></span>
                </div>
                @if (is_active('blog.translate') !== 'active')
                    <div class="mt-6">
                        <label class="form-label">{{ translate('Blog Category') }} <span
                                class="text-danger">*</span></label>
                        <select class="multipleSelect" multiple="multiple" name="blog_categoryId[]">
                            @foreach (get_all_blog_category() as $category)
                                @php $categoryTranslations = parse_translation($category);  @endphp
                                <option value="{{ $category->id }}"
                                    @if (isset($blog)) @foreach ($blog->blogCategories as $blogCategory)
                                    {{ $blogCategory->id == $category->id ? 'selected' : '' }}
                                    @endforeach @endif>
                                    {{ $categoryTranslations['name'] ?? ($category->name ?? '') }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text blog_categoryId_err"></span>
                    </div>
                @endif
                <div class="mt-6">
                    <label for="blog-content" class="form-label">{{ translate('Blog Description') }} <span
                            class="text-danger">*</span></label>
                    <textarea class="summernote form-input" name="description"> {!! clean($translations['description'] ?? ($blog->description ?? '')) !!}</textarea>
                    <span class="text-danger error-text description_err"></span>
                </div>
            </div>
            @if (is_active('blog.translate') !== 'active')
                <div class="col-span-full md:col-span-5 card">
                    <h6 class="leading-none text-xl font-semibold text-heading">
                        {{ translate('Media') }}
                    </h6>
                    <div class="mt-7">
                        <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                            {{ translate('Image') }} <span class="text-danger">*</span>
                        </p>
                        <label for="imgage"
                            class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                            <input type="file" hidden name="image" id="imgage"
                                class="dropzone dropzone-image img-src peer/file">
                            <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                <img src="{{ asset('lms/') }}/assets/images/icons/upload-file.svg" alt="file-icon"
                                    class="size-8 lg:size-auto">
                                <div class="text-gray-500 dark:text-dark-text mt-2">
                                    {{ translate('Choose file') }}
                                </div>
                            </span>
                            <span class="text-danger error-text image_err"></span>
                        </label>
                        <div class="preview-zone dropzone-preview">
                            <div class="box box-solid">
                                <div class="box-body flex items-center gap-2 flex-wrap">

                                    @if (isset($blog) && fileExists('lms/blogs', $blog->thumbnail) == true && $blog->thumbnail != '')
                                        <div class="img-thumb-wrapper"> <button class="remove">
                                                <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                            <img class="img-thumb" width="100"
                                                src="{{ asset('storage/lms/blogs/' . $blog->thumbnail) }}" />
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-span-full card flex justify-end">
                <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                    {{ isset($blog) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </div>
    </form>

    @push('js')
        <script>
            $('.multipleSelect').select2({
                placeholder: "{{ translate('Select Blog Category') }}",
                width: "100%"
            })
        </script>
    @endpush
</x-dashboard-layout>
