<x-dashboard-layout>
    <x-slot:title> {{ translate('Manage Currency') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Currency" page-to="Currency" action-route="{{ route('currency.create') }}" />

    <div class="card overflow-hidden">
        @if ($currencies->count() > 0)
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
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Code') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Symbol') }}
                            </th>

                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Status') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($currencies as $currency)
                            <tr>
                                <td class="px-3.5 py-4">
                                    {{ $currency->name }}
                                </td>

                                <td class="px-3.5 py-4">
                                    {{ $currency->code }}
                                </td>

                                <td class="px-3.5 py-4">
                                    {{ $currency->symbol }}
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="form-check form-switch">
                                        <label class="inline-flex items-center me-5 cursor-pointer">
                                            <input type="checkbox" class="hidden appearance-none peer status-change"
                                                name="status"
                                                data-action="{{ route('currency.status', $currency->id) }}"
                                                {{ $currency->status == 1 ? 'checked' : '' }}>
                                            <span class="switcher switcher-primary-solid"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('currency.edit', $currency->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-edit-2-line text-inherit text-base"></i>
                                        </a>
                                        <button data-action="{{ route('currency.destroy', $currency->id) }}"
                                            class="btn-icon btn-danger-icon-light size-8 delete-btn-cs">
                                            <i class="ri-delete-bin-line text-inherit text-base"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Start Pagination -->
            {{ $currencies->links('portal::admin.pagination.paginate') }}
        @else
            <x-portal::admin.empty-card title="No Currency" action="{{ route('currency.create') }}"
                btnText="Add New" />
        @endif
    </div>
</x-dashboard-layout>
