<x-dashboard-layout>
    <x-slot:title>{{ isset($category) ? translate('Edit') : translate('Create') }} {{ translate('Category') }}
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('category.index') }}"
        title="{{ isset($category) ? 'View' : 'Create' }}" page-to="Category" />

    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-full lg:col-span-6 card">
            <div class="leading-none">
                <label for="title" class="form-label">
                    {{ translate('Title') }}
                    <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                </label>
                <input type="text" id="title" name="title" readonly value="{{ $category->title ?? '' }}"
                    class="form-input">
            </div>
            <div class="leading-none mt-6">
                <label for="parent_id" class="form-label">{{ translate('Parent') }}</label>
                <select data-select id="parent_id" name="parent_id" readonly class="singleSelect">
                    <option selected disabled data-display="{{ translate('Select none to create a parent category') }}">
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
                <select data-select id="icon" name="icon_id" class="singleSelect" readonly>
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
                <input type="number" id="order" name="order" readonly class="form-input"
                    placeholder="{{ translate('Enter Position') }}" value="{{ $category->order ?? '' }}">
            </div>
            <div class="leading-none mt-6">
                <label for="meta_title" class="form-label">
                    {{ translate('Meta Title') }}
                </label>
                <input type="text" id="meta_title" name="meta_title" readonly
                    value="{{ $category->meta_title ?? '' }}" class="form-input"
                    placeholder="{{ translate('Enter Meta Title') }}">
            </div>
        </div>
        <div class="col-span-full lg:col-span-6 card">
            <label class="card-title"> {{ translate('Category Image') }}</label>
            <div class="preview-zone dropzone-preview">
                <div class="box box-solid">
                    <div class="box-body flex items-center gap-2 flex-wrap">
                        @if (isset($category) &&
                                fileExists($folder = 'lms/categories', $fileName = $category->image) == true &&
                                $category->image !== '')
                            <div class="img-thumb-wrapper">
                                <img class="img-thumb" src="{{ asset('storage/lms/categories/' . $category->image) }}"
                                    alt="">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-full card">
            <label for="meta_description" class="card-title">
                {{ translate('Meta Description') }}
            </label>
            <div class="card-description text-gray-500 dark:text-dark-text-two mt-4">
                {!! clean($category->meta_description ?? '') !!}
            </div>
        </div>
    </div>
</x-dashboard-layout>
