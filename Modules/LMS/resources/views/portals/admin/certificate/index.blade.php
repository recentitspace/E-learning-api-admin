<x-dashboard-layout>
    <x-slot:title>{{ translate('Manage Certificate') }}</x-slot:title>
    <!-- Page Breadcrumb -->
    <x-portal::admin.breadcrumb title="All Certificate" page-to="Certificate" />

    <div class="card">
        <div class="overflow-x-auto scrollbar-table">
            <table
                class="table-auto border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium">
                <thead>
                    <tr class="text-primary-500">
                        <th
                            class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                            {{ translate('Title') }}
                        </th>
                        <th
                            class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                            {{ translate('Type') }}
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
                    @foreach ($certificates as $certificate)
                        <tr>
                            <td class="px-4 py-4">{{ $certificate?->title }}</td>
                            <td class="px-4 py-4">{{ $certificate?->type }}</td>
                            <td class="px-4 py-4">
                                <label class="inline-flex items-center me-5 cursor-pointer">
                                    <input type="checkbox" class="appearance-none peer status-change" name="status"
                                        {{ $certificate?->status == 1 ? 'checked' : '' }}>
                                    <span class="switcher switcher-primary-solid"></span>
                                </label>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('certificate.edit', $certificate->id) }}"
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
    </div>
</x-dashboard-layout>
