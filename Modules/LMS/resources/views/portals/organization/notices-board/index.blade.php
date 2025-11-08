<x-dashboard-layout>
    <x-slot:title> {{ translate('Notice Board') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb 
        title="Notice Board List" 
        page-to="Notice Board"
        action-route="{{ route('organization.noticeboard.create') }}" 
    />

    @if ($noticesBoards->count() > 0)
        <div class="card overflow-hidden">
            <x-portal::noticeboard.index :noticesBoards=$noticesBoards />
        </div>
    @else
        <x-portal::admin.empty-card 
            title="No notice available" 
            action="{{ route('organization.noticeboard.create') }}"
            btnText="Add New" 
        />
    @endif
</x-dashboard-layout>
