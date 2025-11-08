<x-dashboard-layout>
    <x-slot:title> {{ translate('My Certificate') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="My All Certificate" page-to="Certificate" />
    <!-- Start Main Content -->
    <div class="card overflow-hidden">
        @if ($certificates->count() > 0)
            <x-portal::certificates.certificate-list :certificates=$certificates />
        @else
            <x-portal::admin.empty-card title="You have no Certificate" />
        @endif
    </div>
</x-dashboard-layout>
