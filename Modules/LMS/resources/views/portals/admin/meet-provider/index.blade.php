<x-dashboard-layout>
    <x-slot:title>{{ translate('Manage Meeting') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Meeting Provider" page-to="Meeting"
        action-route="{{ route('meet-provider.create') }}" />

    @if ($meetingProviders->count() > 0)
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary-500">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Name') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($meetingProviders as $meetingProvider)
                            <tr>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center gap-2">
                                        {{ $meetingProvider->name }}
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('meet-provider.edit', $meetingProvider->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-edit-2-line text-inherit text-base"></i>
                                        </a>
                                        <a href="{{ route('meet-provider.show', $meetingProvider->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-eye-line text-inherit text-base"></i>
                                        </a>
                                        <button data-action="{{ route('meet-provider.destroy', $meetingProvider->id) }}"
                                            class="btn-icon btn-danger-icon-light size-8 delete-btn-cs">
                                            <i class="ri-delete-bin-line text-inherit text-base"></i>
                                        </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Start Pagination -->
            {{ $meetingProviders->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="No Meeting Provider" action="{{ route('meet-provider.create') }}"
            btnText="Add New" />
    @endif
</x-dashboard-layout>
