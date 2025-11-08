<x-dashboard-layout>
    <x-slot:title> {{ translate('Notices Board Manage') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Notice Board List" page-to="Notice Board"
        action-route="{{ route('instructor.noticeboard.create') }}" />


    @if (!empty($noticesBoards) && count($noticesBoards) > 0)
        <div class="card overflow-hidden">
            <x-portal::noticeboard.index :noticesBoards=$noticesBoards />
        </div>
    @else
        <x-portal::admin.empty-card title="You didn't create any notice for your student."
            action="{{ route('instructor.noticeboard.create') }}" btnText="Add New" />
    @endif
</x-dashboard-layout>
