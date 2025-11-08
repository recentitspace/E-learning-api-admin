<x-dashboard-layout>
    <x-slot:title> {{ translate('Edit Hero') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('hero.index') }}" title="{{ isset($hero) ? 'Edit' : 'Create' }} Hero"
        page-to="Hero" />
    <form action="{{ isset($hero) ? route('hero.update', $hero->id) : route('hero.store') }}" method="post"
        class="form mb-4" enctype="multipart/form-data">
        @if (isset($hero))
            @method('PUT')
            <input type="hidden" name="id" value="{{ $hero->id }}">
        @endif
        @csrf
        <div class="card">
            <div>
                <label for="title" class="form-label">{{ translate('Title') }} <span
                        class="require-field">*</span></label>
                <input type="text" id="title" name="title" placeholder="{{ translate('Enter Title') }}"
                    class="form-input" value="{{ $hero->title ?? '' }}">
                <span class="text-danger error-text title_err"></span>
            </div>
            <div class="mt-6">
                <label class="form-label"> {{ translate('Theme') }} <span class="require-field">*</span></label>
                <select name="theme_id" class="form-label singleSelect">
                    <option selected disabled> {{ translate('Select Theme') }}</option>
                    @foreach (get_themes() as $key => $theme)
                        <option value="{{ $theme->id }}"
                            {{ isset($hero) && $hero->theme_id == $theme->id ? 'selected' : '' }}>
                            {{ $theme->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger error-text theme_id_err"></span>
            </div>

            <div class="mt-6">
                <div class="flex items-center gap-2">
                    <input id="check-s-1" type="checkbox" name="status" class="check check-primary-solid"
                        {{ isset($hero) && $hero->status ? 'checked' : '' }}>
                    <label for="check-s-1" class="leading-none font-medium text-gray-500 dark:text-dark-text">
                        {{ translate('Enable') }}</label>
                </div>
            </div>
        </div>
        <div class="card flex justify-end">
            <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                {{ isset($hero) ? translate('Update') : translate('Save') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
