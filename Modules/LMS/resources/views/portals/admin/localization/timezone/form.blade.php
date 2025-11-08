<x-dashboard-layout>
    <x-slot:title>{{ isset($timeZone) ? translate('Edit') : translate('Create') }}
        {{ translate('Timezone') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('time-zone.index') }}"
        title="{{ isset($timeZone) ? 'Edit' : 'Create' }}" page-to="State" />
    <form action="{{ isset($timeZone) ? route('time-zone.update', $timeZone->id) : route('time-zone.store') }}"
        method="post" class="form" name="edit_form">
        @if (isset($timeZone))
            @method('PUT')
        @endif
        @csrf
        <div class="grid grid-cols-12 card mb-0">
            <div class="col-span-full md:col-span-6">
                <div class="leading-none">
                    <label for="courseTitle" class="form-label">{{ translate('Name') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select class="singleSelect form-input" id="time_zone" name="name">
                        <option selected disabled>{{ translate('Select Time Zone') }}</option>
                        @foreach (getTimezone() as $key => $getTimezone)
                            <option value="{{ $getTimezone['value'] }}"
                                {{ isset($timeZone) && $timeZone->name == $getTimezone['value'] ? 'selected' : '' }}>
                                {{ $getTimezone['label'] }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text name_err">
                </div>
                <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5 dk-theme-card-square">
                    {{ isset($timeZone) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </div>
    </form>

    @push('js')
        <script type="text/javascript">
            document.forms['edit_form'].elements['name'].value = "{{ $timeZone->name ?? '' }}";
        </script>
    @endpush
</x-dashboard-layout>
