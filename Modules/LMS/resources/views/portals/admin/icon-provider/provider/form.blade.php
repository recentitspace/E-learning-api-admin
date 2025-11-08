<x-dashboard-layout>
    <x-slot:title>{{ translate('Edit Provider') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="{{ isset($provider) ? 'Edit' : 'Create' }}" page-to="Provider" />
    <form action="{{ isset($provider) ? route('provider.update', $provider->id) : route('provider.store') }}"
        method="post" class="form">
        @if (isset($provider))
            @method('PUT')
        @endif
        @csrf
        <div class="grid grid-cols-12 card mb-0">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label for="courseTitle" class="form-label">
                        {{ translate('Name') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="text" id="courseTitle" name="name" value="{{ $provider->name ?? '' }}"
                        class="form-input">
                    <span class="text-danger error-text name_err"></span>
                </div>
                <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5 dk-theme-card-square">
                    {{ isset($provider) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
