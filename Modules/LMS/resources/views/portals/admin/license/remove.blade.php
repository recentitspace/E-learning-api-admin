<x-dashboard-layout>
    <x-slot:title>{{ translate('License Key Remove') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="License key remove" page-to="" />
    <form action="{{ route('license.remove') }}" method="post" class="form">
        @csrf
        <div class="grid grid-cols-12 card mb-0">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label for="courseTitle" class="form-label"> {{ translate('License Code') }}
                        <span class="text-danger" title="This field is required."><b>*</b></span>
                    </label>
                    <input type="text" id="courseTitle" name="license_code" class="form-input">
                    <span class="text-danger error-text license_code_err"></span>
                </div>
                <button type="submit" class="btn b-solid btn-danger-solid w-max mt-5">
                    {{ translate('Remove') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
