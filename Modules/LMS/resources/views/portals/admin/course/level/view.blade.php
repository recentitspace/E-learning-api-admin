<x-dashboard-layout>
    <x-slot:title> {{ translate('View Level') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('level.index') }}" title="View" page-to="Level" />

    <div class="grid grid-cols-12 card">
        <div class="col-span-full md:col-span-6">
            <div>
                <label for="name" class="form-label">{{ translate('Name') }}
                    <span class="text-danger"><b>*</b></span>
                </label>
                <input type="text" id="name" name="name" value="{{ $level->name ?? '' }}" class="form-input"
                    readonly>
                <span class="text-danger error-text name_err"></span>
            </div>
        </div>
    </div>
</x-dashboard-layout>
