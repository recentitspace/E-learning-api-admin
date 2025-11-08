<x-dashboard-layout>
    <x-slot:title>{{ translate('Manage Icon Provider') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Provider" page-to="Provider" action-route="{{ route('provider.create') }}" />
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
                            {{ translate('Status') }}</th>
                        <th
                            class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                            {{ translate('Action') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                    @foreach ($providers as $provider)
                        <tr>
                            <td class="px-3.5 py-4">
                                {{ $provider->name }}
                            </td>
                            <td class="px-3.5 py-4">
                                <label class="inline-flex items-center me-5 cursor-pointer">
                                    <input type="checkbox" class="appearance-none peer status-change" name="status"
                                        data-action="{{ route('provider.status', $provider->id) }}"
                                        {{ $provider->status == 1 ? 'checked' : '' }} role="switch">
                                    <span class="switcher switcher-primary-solid"></span>
                                </label>
                            </td>
                            <td class="px-3.5 py-4">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('provider.edit', $provider->id) }}"
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
        {{ $providers->links('portal::admin.pagination.paginate') }}
    </div>
</x-dashboard-layout>
