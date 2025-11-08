@php
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    $testimonial = $testimonial ?? null;
    if ($testimonial && $locale) {
        $translations = parse_translation($testimonial, $locale);
    }
@endphp

<x-dashboard-layout>
    <x-slot:title>
        {{ isset($testimonial) ? translate('Edit Testimonial') : translate('Create Testimonial') }}
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('testimonial.index') }}"
        title="{{ isset($testimonial) ? 'Edit' : 'Create' }}" page-to="Testimonial" />
    @if (is_active('testimonial.translate') === 'active')
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
    <form action="{{ isset($testimonial) ? route('testimonial.update', $testimonial->id) : route('testimonial.store') }}"
        method="POST" class="form" enctype="multipart/form-data">
        @csrf
        @if (isset($testimonial))
            @method('put')
        @endif
        <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full md:col-span-7 card">
                <div class="p-1.5">
                    <h6 class="leading-none text-xl font-semibold text-heading">
                        {{ isset($testimonial) ? translate('Edit Testimonial') : translate('Add New Testimonial') }}
                    </h6>
                    <div class="mt-7">
                        <div>
                            <label for="testimonial-name" class="form-label">{{ translate('Name') }}<span
                                    class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span></label>
                            <input type="text" id="testimonial-name" placeholder="{{ translate('Enter Your Name') }}"
                                name="name" class="form-input"
                                value="{{ $translations['name'] ?? $testimonial->name ?? '' }}">
                            <span class="text-danger error-text name_err"></span>
                        </div>
                        <div class="mt-6">
                            <label for="designation" class="form-label">{{ translate('Designation') }}<span
                                    class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span></label>
                            <input type="text" id="designation"
                                placeholder="{{ translate('Enter Your Designation') }}" class="form-input"
                                name="designation"
                                value="{{ $translations['designation'] ?? $testimonial->designation ?? '' }}" />
                            <span class="text-danger error-text designation_err"></span>
                        </div>
                        <div class="mt-6">
                            <label for="rating" class="form-label">{{ translate('Rating') }}<span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span></label>
                            <input type="text" id="rating"
                                placeholder="{{ translate('Enter your Rating out of 5') }}" name="rating"
                                class="form-input" value="{{ $translations['rating'] ?? $testimonial->rating ?? '' }}">
                            <span class="text-danger error-text rating_err"></span>
                        </div>
                        <div class="mt-6">
                            <label for="testimonial-content" class="form-label">{{ translate('Description') }}</label>
                            <textarea class="summernote form-input" name="comments">{!! clean($translations['comments'] ?? $testimonial->comments ?? '') !!}</textarea>
                        </div>
                    </div>

                </div>
            </div>
            @if (is_active('testimonial.translate') !== 'active')
            <div class="col-span-full md:col-span-5 card">
                <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Media') }}</h6>
                <div class="mt-7">
                    <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                        {{ translate('Image') }}({{ translate('200') }}x{{ translate('200') }})
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
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
                                @if (isset($testimonial) && fileExists('lms/testimonials', $testimonial->profile_image) == true &&
                                            $testimonial->profile_image != '')
                                    <div class="img-thumb-wrapper">
                                        <img class="img-thumb" width="100"
                                            src="{{ asset('storage/lms/testimonials/' . $testimonial->profile_image) }}" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="card flex-center justify-end">
            <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                {{ isset($testimonial) ? translate('Update') : translate('Submit') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
