<x-dashboard-layout>
    <x-slot:title> {{ translate('My Course') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="My All Bundle Course" page-to="Course" />
    @if ($bundlesPurchases->total() > 0)
        <div class="grid grid-cols-12 gap-x-4 gap-y-6 card">
            @foreach ($bundlesPurchases as $bundlesPurchase)
                <x-portal::student.bundle-purchase :bundlesPurchase=$bundlesPurchase />
            @endforeach
            {{ $bundlesPurchases->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="You have no bundle course to show" />
    @endif
</x-dashboard-layout>
