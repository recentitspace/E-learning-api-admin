<x-dashboard-layout>
    <x-slot:title> {{ translate('Review Manage') }} </x-slot:title>
    <x-portal::admin.breadcrumb title="Review List" page-to="Review" />
    <div class="card overflow-hidden">
        @if (count($reviews) > 0)
            <div class="overflow-x-auto scrollbar-table">
                <x-portal::review.list :reviews=$reviews />
            </div>
            {{ $reviews->links('portal::admin.pagination.paginate') }}
        @else
            <x-portal::admin.empty-card title="No Course Review" />
        @endif
    </div>
</x-dashboard-layout>
