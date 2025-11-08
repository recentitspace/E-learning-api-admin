@php

    $userInfo = $enrollment?->user->userable ?? null;
    $course = $enrollment?->course ?? null;

    $userTranslations = parse_translation($userInfo);
    $courseTranslations = parse_translation($course);

@endphp
<x-dashboard-layout>
    <x-slot:title>{{ translate('New Enrolled') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('enrollment.index') }}" title="View Enroll" page-to="New Enroll" />

    <div class="grid grid-cols-12 card">
        <div class="col-span-full md:col-span-6">
            <div class="leading-none">
                <label for="courseTitle" class="form-label"> {{ translate('Student Name') }} : </label>
                {{ $userTranslations['first_name'] ?? $userInfo?->first_name }}
                {{ $userTranslations['last_name'] ?? $userInfo?->last_name }}
            </div>
            <div class="mt-6 leading-none">
                <label for="code" class="form-label">
                    {{ translate('Enrolled Course') }} :
                </label>
                {{ $courseTranslations['title'] ?? ($course->title ?? '')   }}
            </div>
        </div>
    </div>
</x-dashboard-layout>
