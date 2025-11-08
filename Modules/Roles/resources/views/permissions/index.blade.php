<x-dashboard-layout>
    <x-slot:title>{{ translate('Manage Permission') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Permission List" page-to="Permission"
        action-route="{{ route('permission.create') }}" />
    @if (!empty($permissions) || $permissions->count() > 0)
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary-500">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Name') }}</th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Module Name') }}</th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($permissions as $permission)
                            <tr>
                                <td class="px-3.5 py-4">
                                    {{ $permission->name }}
                                </td>
                                <td class=" gap-2 px-3.5 py-4">
                                    {{ $permission->module }}
                                </td>
                                <td class=" px-3.5 py-4">
                                    <div class="flex items-center gap-1">
                                        <!-- Dirrect Message -->
                                        <a href="{{ route('permission.edit', $permission->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-edit-2-line text-inherit text-base"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Start Pagination -->
            {{ $permissions->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="Permission" action="{{ route('permission.create') }}" btnText="Add New" />
    @endif
</x-dashboard-layout>
