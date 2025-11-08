<x-dashboard-layout>

    @php
        $button = $slider['buttons'] ?? [];
        $slider = $slider ?? null;
        $locale = request()->locale ?? app()->getLocale();
        $translations = parse_translation($slider, $locale);
    @endphp
    <x-slot:title> {{ translate('Edit Page') }}</x-slot:title>

    <x-portal::admin.breadcrumb back-url="{{ route('slider.index') }}"
        title="{{ isset($slider) ? 'Edit' : 'Create' }} Slider" page-to="Slider" />
    @if (is_active('slider.translate') === 'active')
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
    <form action="{{ isset($slider) ? route('slider.update', $slider->id) : route('slider.store') }}" method="post"
        class="form mb-4" enctype="multipart/form-data">
        @csrf
        @if (isset($slider))
            @method('PUT')
            <input type="hidden" name="id" class="form-input" value="{{ $slider->id ?? '' }}">
            <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
        @endif
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6 card">
                <div class="leading-none">
                    <label for="title" class="form-label">{{ translate('Title') }}</label>
                    <input type="text" id="title" name="title"
                        value="{{ $translations['title'] ?? $slider->title ?? '' }}" class="form-input">
                    <span class="text-danger error-text title_err"></span>
                </div>
                <div class="leading-none mt-4">
                    <label class="form-label">{{ translate('Highlight Text') }}</label>
                    <input type="text" name="highlight_text"
                        value="{{ $translations['highlight_text'] ?? $slider->highlight_text ?? '' }}"
                        class="form-input">
                </div>
                <div class="leading-none mt-4">
                    <label for="sub_title" class="form-label">{{ translate('Sub Title') }}</label>
                    <input type="text" id="sub_title" name="sub_title"
                        value="{{ $translations['sub_title'] ?? $slider->sub_title ?? '' }}" class="form-input">
                </div>
                @if (is_active('slider.translate') !== 'active')
                    <div class="leading-none mt-4">
                        <label class="form-label">{{ translate('Hero') }} <span
                                class="require-field"><b>*</b></span></label>
                        <select name="hero_id" class="singleSelect">
                            <option selected disabled> {{ translate('Select Hero') }}</option>
                            @foreach (get_heroes() as $hero)
                                <option value="{{ $hero->id }}"
                                    {{ isset($slider) && $hero->id == $slider->hero_id ? 'selected' : '' }}>
                                    {{ $hero->title }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text hero_id_err"></span>
                    </div>
                @endif

                <div class="leading-none mt-4">

                    <label class="form-label"> {{ translate('Button') }}</label>
                    <div class="mb-4">
                        <input type="text" name="buttons[0][name]"
                            value="{{ $translations['buttons']['name'] ?? $button['name'] ?? '' }}"
                            class="form-input" placeholder="{{ translate('Button Text') }}">
                    </div>
                    @if (is_active('slider.translate') !== 'active')
                        <input type="text" name="buttons[0][link]" value="{{ $button['link'] ?? '' }}"
                            class="form-input" placeholder="{{ translate('Button Link') }}">
                    @endif
                </div>
                <div class="leading-none mt-4">
                    <label for="description" class="form-label">{{ translate('Description') }}</label>
                    <textarea name="description" rows="5" class="form-input">{{ clean($translations['description'] ?? $slider->description ?? '') }}</textarea>
                    <span class="text-danger error-text description_err"></span>
                </div>

                <div class="leading-none mt-4">
                    <div class="flex items-center gap-2">
                        <input id="check-s-1" type="checkbox" name="status" class="check check-primary-solid"
                            {{ isset($slider) && $slider->status ? 'checked' : '' }}>
                        <label for="check-s-1" class="leading-none font-medium text-gray-500 dark:text-dark-text">
                            {{ translate('Enable') }}</label>
                    </div>
                </div>
            </div>

            @if (is_active('slider.translate') !== 'active')
                <div class="col-span-full lg:col-span-6 card">
                    <label for="imgage"
                        class="dropzone-wrappe mb-4 file-container ac-bg text-xs leading-none font-semibold cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10">
                        <input type="file" hidden name="slider_image" id="imgage"
                            class="dropzone dropzone-image img-src peer/file">
                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                            <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}" alt="file-icon"
                                class="size-8 lg:size-auto">
                            <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }} </div>
                        </span>
                        <span class="text-danger error-text slider_image_err"></span>
                    </label>
                    <div class="preview-zone dropzone-preview">
                        <div class="box box-solid">
                            <div class="box-body flex items-center gap-2 flex-wrap">
                                @if (isset($slider) &&
                                        fileExists($folder = 'lms/sliders', $fileName = $slider?->image) == true &&
                                        $slider?->image !== '')
                                    <div class="img-thumb-wrapper">
                                        <img class="img-thumb" width="100"
                                            src="{{ asset('storage/lms/sliders/' . $slider->image) }}" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-span-full card flex justify-end">
                <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                    {{ isset($slider) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
