<x-dashboard-layout>
    <x-slot:title>{{ translate('View Tag') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('tag.index') }}" title="View" page-to="Tag" />
    <div class="grid grid-cols-12 card">
        <div class="col-span-full md:col-span-6">
            <div>
                <label for="name" class="form-label">{{ translate('Name') }}
                    <span class="text-danger"><b>*</b></span>
                </label>
                <input type="text" id="name" name="name" value="{{ $tag->name ?? '' }}" readonly
                    class="form-input">
                <span class="text-danger error-text name_err"></span>
            </div>
        </div>
    </div>
</x-dashboard-layout>
