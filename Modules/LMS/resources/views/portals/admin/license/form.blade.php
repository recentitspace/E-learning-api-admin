<x-dashboard-layout>
    <x-slot:title>{{ translate('License Update') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="License Update" page-to="" />
    <form action="{{ route('license.update') }}" method="post" class="form">
        @csrf
        <div class="grid grid-cols-12 card mb-0">
            <div class="col-span-full md:col-span-6">

                <div class="leading-none">
                    <label for="email" class="form-label"> {{ translate('Email') }}
                        <span class="text-danger" title="This field is required."><b>*</b></span>
                    </label>
                    <input type="text" id="email" name="email" class="form-input">
                    <span class="text-danger error-text email_err"></span>
                </div>
                <div class="leading-none mt-2">
                    <label for="license_code" class="form-label"> {{ translate('License Code') }}
                        <span class="text-danger" title="This field is required."><b>*</b></span>
                    </label>
                    <input type="text" id="license_code" name="license_code" class="form-input">
                    <span class="text-danger error-text license_code_err"></span>
                </div>
                <button type="submit" class="btn b-solid btn-info-solid w-max mt-5">
                    {{ translate('Update') }}
                </button>
            </div>
        </div>
    </form>
</x-dashboard-layout>
