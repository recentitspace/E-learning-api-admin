<x-dashboard-layout>
    <x-slot:title>
        {{ isset($meetingProvider) ? translate('Edit') : translate('Create') }} {{ translate('Meeting') }}
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('meet-provider.index') }}"
        title="{{ isset($meetingProvider) ? 'Edit' : 'Create' }}" page-to="Meeting" />
    <form
        action="{{ isset($meetingProvider) ? route('meet-provider.update', $meetingProvider->id) : route('meet-provider.store') }}"
        method="post" class="form" enctype="multipart/form-data">
        @if (isset($meetingProvider))
            @method('PUT')
        @endif
        @csrf
        <div class="grid grid-cols-12 card mb-0">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label for="name" class="form-label">{{ translate('Name') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" id="name" name="name"
                        placeholder="{{ translate('Enter Meeting Provider') }}" class="form-input"
                        value="{{ $meetingProvider->name ?? '' }}">
                    <span class="text-danger error-text name_err"></span>
                </div>
                <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5 dk-theme-card-square">
                    {{ isset($meetingProvider) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
