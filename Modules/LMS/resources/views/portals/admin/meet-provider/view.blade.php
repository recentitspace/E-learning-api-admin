<x-dashboard-layout>
    <x-slot:title>
        {{ translate('View Meeting Provider') }}
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('meet-provider.index') }}" title="View" page-to="Meeting" />
    <div class="grid grid-cols-12 card mb-0">
        <div class="col-span-full md:col-span-6">
            <div class="leading-none">
                <label for="name" class="form-label">{{ translate('Name') }}
                    <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                </label>
                <input type="text" id="name" name="name" readonly
                    placeholder="{{ translate('Enter Meeting Provider') }}" class="form-input"
                    value="{{ $meetingProvider->name ?? '' }}">
                <span class="text-danger error-text name_err"></span>
            </div>
        </div>
    </div>
</x-dashboard-layout>
