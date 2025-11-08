<x-dashboard-layout>
    <x-slot:title>{{ isset($permission) ? translate('Edit') : translate('Create') }}
        {{ translate('Permission') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="{{ isset($permission) ? 'Edit' : 'Create' }} Permission" page-to="Permission"
        back-url="{{ route('permission.index') }}" />
    <form action="{{ isset($permission) ? route('permission.update', $permission->id) : route('permission.store') }}"
        method="post" class="form">
        @csrf
        @if (isset($permission))
            @method('PUT')
        @endif
        <div class="grid grid-cols-12 card">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label class="form-label"> {{ translate('Name') }} <span
                            class="require-field"><b>*</b></span></label>
                    <input type="text" name="name" value="{{ $permission->name ?? '' }}" class="form-input">
                    <span class="text-danger error-text name_err"></span>
                </div>
                <div class="leading-none mt-6">
                    <label class="form-label"> {{ translate('Module Name') }} <span
                            class="require-field"><b>*</b></span></label>
                    <input type="text" name="module" value="{{ $permission->module ?? '' }}" class="form-input">
                    <span class="text-danger error-text module_err"></span>
                </div>
                <input type="hidden" name="guard_name" value="admin" class="form-input">
            </div>
        </div>
        <div class="card flex justify-end">
            <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                {{ isset($permission) ? translate('Update') : translate('Save') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
