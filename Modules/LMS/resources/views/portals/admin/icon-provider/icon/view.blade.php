<x-dashboard-layout>
    <x-slot:title>{{ translate('View Icon') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('icon.index') }}" title="{{ isset($icon) ? ' View' : 'Create' }}"
        page-to="Provider" />

    <div class="grid grid-cols-12 card mb-0">
        <div class="col-span-full md:col-span-6">
            <div class="leading-none">
                <label for="courseTitle" class="form-label"> {{ translate('Icon Provider') }}
                    <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                </label>
                <select data-select name="icon_provider_id" class="singleSelect" readonly>
                    <option selected disabled data-display="{{ translate('Selected Icon Provider') }}">
                        {{ translate('Selected Icon Provider') }}
                    </option>
                    @foreach (get_all_icon_provider() as $provider)
                        <option value="{{ $provider->id }}"
                            {{ isset($icon) && $provider->id == $icon->icon_provider_id ? 'selected' : '' }}>
                            {{ $provider->name }}
                        </option>
                    @endforeach
                </select>
                <span class="text-danger error-text icon_provider_id_err"></span>
            </div>
            <div class="mt-6 leading-none">
                <label for="courseTitle" class="form-label">{{ translate('Name') }}
                    <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                </label>
                <input type="text" id="courseTitle" name="icon" readonly value="{{ $icon->icon ?? '' }}"
                    class="form-input">
                <span class="text-danger error-text icon_err"></span>
            </div>
        </div>
    </div>
</x-dashboard-layout>
