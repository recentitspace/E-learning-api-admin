@php
    $rolePermissions = isset($rolePermissions) && is_array($rolePermissions) ? $rolePermissions : [];
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ isset($role) ? translate('Edit') : translate('Create') }} {{ translate('Role') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="{{ isset($role) ? 'Edit' : 'Create' }} Role" page-to="Role"
        back-url="{{ route('role.index') }}" />
    <form action="{{ isset($role) ? route('role.update', $role->id) : route('role.store') }}" method="post"
        class="form">
        @csrf
        @if (isset($role))
            @method('PUT')
        @endif
        <div class="card">
            <div class="grid grid-cols-12 gap-x-4">
                <div class="col-span-full md:col-span-6">
                    <div class="leading-none">
                        <label for="title" class="form-label"> {{ translate('Name') }} <span
                                class="require-field"><b>*</b></span></label>
                        <input type="text" id="title" name="name" value="{{ $role->name ?? '' }}"
                            class="form-input">
                        <span class="text-danger error-text name_err"></span>
                    </div>

                    <input type="hidden" name="guard_name" value="admin" class="form-input">
                    <div class="mt-5 mb-3">
                        <h6 class="card-title text-lg"> {{ translate('Select Permission') }} </h6>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-7 h-full max-h-[600px] overflow-y-scroll">
                @foreach ($permissions as $key => $permission)
                    <div class="col-span-full sm:col-span-6 lg:col-span-4 xl:col-span-3">
                        <div class="group-permission h-full dk-border-one rounded-10 dk-theme-card-square p-3">
                            <div class="flex items-center gap-2 border-b border:dk-border-one pb-3">
                                <input id="check-s-{{ $key }}" type="checkbox"
                                    class="check check-primary-solid check-md check-enable-parent">
                                <label for="check-s-{{ $key }}" class="card-title text-base font-medium leading-none mt-0.5">
                                    {{ $key }}</label>
                            </div>
                            <div class="mt-3">
                                @foreach ($permission as $value)
                                    <div class="flex items-center gap-2 mb-2">
                                        <input id="check-s-{{ $value->id }}" type="checkbox"
                                            class="check check-primary-solid check-sm check-enable-child"
                                            name="permissions[]" value="{{ $value->name }}"
                                            {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                        <label for="check-s-{{ $value->id }}"
                                            class="form-label text-base m-0">{{ $value->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-end mt-10">
                <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                    {{ isset($role) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
