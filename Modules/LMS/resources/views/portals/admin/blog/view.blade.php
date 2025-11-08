<x-dashboard-layout>
    <x-slot:title>
        {{ translate('View Blog') }}
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('blog.index') }}" title="View" page-to="Blog" />

    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-full md:col-span-7 card">
            <div>
                <label for="blog-title" class="form-label">{{ translate('Blog Title') }} <span class="text-danger">*</span>
                </label>
                <input type="text" id="blog-title" placeholder="{{ translate('Title') }}" name="title" readonly
                    class="form-input" autocomplete="off" value="{{ $blog->title ?? '' }}">
                <span class="text-danger error-text title_err"></span>
            </div>
            <div class="mt-6">
                <label class="form-label">{{ translate('Blog Category') }} <span class="text-danger">*</span></label>
                <select class="multipleSelect" multiple="multiple" name="blog_categoryId[]" readonly>
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
            <div class="mt-6">
                <label for="blog-content" class="form-label">{{ translate('Blog Description') }} <span
                        class="text-danger">*</span></label>
                <textarea class="summernote form-input" name="description"> {!! clean($blog->description ?? '') !!}</textarea>
                <span class="text-danger error-text description_err"></span>
            </div>
        </div>
        <div class="col-span-full md:col-span-5 card">
            <h6 class="leading-none text-xl font-semibold text-heading">
                {{ translate('Media') }}
            </h6>
            <div class="mt-7">
                <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                    {{ translate('Image') }} <span class="text-danger">*</span>
                </p>

                <div class="preview-zone dropzone-preview">
                    <div class="box box-solid">
                        <div class="box-body flex items-center gap-2 flex-wrap">
                            @if (isset($blog) && fileExists('lms/blogs', $blog->thumbnail) == true && $blog->thumbnail != '')
                                <div class="img-thumb-wrapper">
                                    <img class="img-thumb" width="100"
                                        src="{{ asset('storage/lms/blogs/' . $blog->thumbnail) }}" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('js')
            <script>
                $('.multipleSelect').select2({
                    placeholder: "{{ translate('Select Blog Category') }}",
                    width: "100%"
                })
            </script>
        @endpush
</x-dashboard-layout>
