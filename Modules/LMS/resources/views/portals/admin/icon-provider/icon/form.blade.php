<x-dashboard-layout>
    <x-slot:title>{{ translate('Edit Icon') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('icon.index') }}" title="{{ isset($icon) ? ' Edit' : 'Create' }}"
        page-to="Provider" />
    <form action="{{ isset($icon) ? route('icon.update', $icon->id) : route('icon.store') }}" method="post"
        class="form">
        @if (isset($icon))
            @method('PUT')
        @endif
        @csrf
        <div class="grid grid-cols-12 card mb-0">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label for="courseTitle" class="form-label"> {{ translate('Icon Provider') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select data-select name="icon_provider_id" class="singleSelect">
                        <option selected disabled data-display="{{ translate('Selected Icon Provider') }}">
                            {{ translate('Selected Icon Provider') }} </option>
                        @foreach (get_all_icon_provider() as $provider)
                            <option value="{{ $provider->id }}"
                                {{ isset($icon) && $provider->id == $icon->icon_provider_id ? 'selected' : '' }}>
                                {{ $provider->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text icon_provider_id_err"></span>
                </div>
                <div class="mt-6 leading-none">
                    <label for="courseTitle" class="form-label">{{ translate('Name') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" id="courseTitle" name="icon" value="{{ $icon->icon ?? '' }}"
                        class="form-input">
                    <span class="text-danger error-text icon_err"></span>
                </div>
                <div class="mt-2 text-sm text-gray-500 dark:text-dark-text">
                    <b class="text-danger">{{ translate('Note') }}:</b>
                    {{ translate('Only Remix Icon Class, example') }}
                    -
                    <input type="text" readonly value="<i class='ri-add-line'></i>">
                </div>
                <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5 dk-theme-card-square">
                    {{ isset($icon) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
