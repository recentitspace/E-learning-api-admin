@php
    $general = get_theme_option(key: 'general') ?? [];
@endphp

<!-- EMAIL -->
<div class="col-span-full sm:col-span-6 lg:col-span-3">
    <div class="bg-primary-50 rounded-xl flex-center flex-col text-center py-12 px-4 h-full">
        <div class="size-14 rounded-50 flex-center bg-primary text-white p-2">
            <i class="ri-mail-open-fill text-2xl"></i>
        </div>
        <div class="area-title text-2xl !leading-none mt-5">
            {{ translate('Email') }}
        </div>
        <p class="area-description text-sm mt-4"> {{ $general['email'] ?? '' }}</p>
        @if (isset($general['second_email']))
            <p class="area-description text-sm mt-1"> {{ $general['second_email'] ?? '' }}</p>
        @endif
    </div>
</div>
<!-- PHONE -->
<div class="col-span-full sm:col-span-6 lg:col-span-3">
    <div class="bg-primary-50 rounded-xl flex-center flex-col text-center py-12 px-4 h-full">
        <div class="size-14 rounded-50 flex-center bg-primary text-white p-2">
            <i class="ri-phone-fill text-2xl"></i>
        </div>
        <div class="area-title text-2xl !leading-none mt-5">
            {{ translate('Phone') }}
        </div>
        <p class="area-description text-sm mt-4">{{ $general['phone'] ?? '' }}</p>

        @if (isset($general['second_phone']))
            <p class="area-description text-sm mt-1">{{ $general['second_phone'] ?? '' }}</p>
        @endif
    </div>
</div>
<!-- OFFICE HOUR -->
<div class="col-span-full sm:col-span-6 lg:col-span-3">
    <div class="bg-primary-50 rounded-xl flex-center flex-col text-center py-12 px-4 h-full">
        <div class="size-14 rounded-50 flex-center bg-primary text-white p-2">
            <i class="ri-home-office-fill text-2xl"></i>
        </div>
        <div class="area-title text-2xl !leading-none mt-5">
            {{ translate('Office Hour') }}
        </div>
        <p class="area-description text-sm mt-4"> {{ $general['office_hours'] ?? '' }} </p>
        @if (isset($general['support_hours']))
            <p class="area-description text-sm mt-1"> {{ translate('Online') }} {{ $general['support_hours'] ?? '' }}
            </p>
        @endif
    </div>
</div>
<!-- LOCATION -->
<div class="col-span-full sm:col-span-6 lg:col-span-3">
    <div class="bg-primary-50 rounded-xl flex-center flex-col text-center py-12 px-4 h-full">
        <div class="size-14 rounded-50 flex-center bg-primary text-white p-2">
            <i class="ri-map-pin-fill text-2xl"></i>
        </div>
        <div class="area-title text-2xl !leading-none mt-5">
            {{ translate('Location') }}
        </div>
        <p class="area-description text-sm mt-4">
            {{ $general['address'] ?? null }}
        </p>
    </div>
</div>
