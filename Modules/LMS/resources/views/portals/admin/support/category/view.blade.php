@php
    $translations = parse_translation($supportCategory);
@endphp

<x-dashboard-layout>
    <x-slot:title> {{ translate('support-category/view') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('support-ticket.category.index') }}" title="{{ translate('View') }}"
        page-to="Support" />
    <div class="card">
        <label for="forumTitle" class="form-label">{{ translate('Name') }} <span class="text-danger"> *</span>
        </label>
        <input type="text" id="forumName" placeholder="{{ translate('Name') }}" name="name"
            value="{{ $translations['name'] ?? ($supportCategory->name ?? '') }}" class="form-input" readonly>
        <span class="text-danger error-text name_err"></span>
    </div>
</x-dashboard-layout>
