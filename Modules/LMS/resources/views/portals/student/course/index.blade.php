<x-dashboard-layout>
    <x-slot:title> {{ translate('My Course') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="My All Enroll Course" page-to="Course" />
    <!-- Start Main Content -->
    <div class="card overflow-hidden">
        @if ($enrollments->total() > 0)
            <div class="grid grid-cols-12 gap-x-4 gap-y-5">
                @foreach ($enrollments as $enrollment)
                    <x-portal::student.purchase-course :purchase=$enrollment />
                @endforeach
                <!-- PAGINATION -->
                {{ $enrollments->links('portal::admin.pagination.paginate') }}
            </div>
        @else
            <x-portal::admin.empty-card title="You have no paid course to show" />
        @endif
    </div>
</x-dashboard-layout>
