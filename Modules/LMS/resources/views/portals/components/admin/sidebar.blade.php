@if (isInstructor())
    <x-portal::admin.instructor-sidebar />
@endif

@if (isOrganization())
    <x-portal::admin.org-sidebar />
@endif

@if (isStudent())
    <x-portal::admin.student-sidebar />
@endif

@if (isAdmin())
    <x-portal::admin.admin-sidebar />
@endif
@push('js')
    <script src="{{ edulab_asset('lms/assets/js/component/app-menu-bar.js') }}"></script>
@endpush
