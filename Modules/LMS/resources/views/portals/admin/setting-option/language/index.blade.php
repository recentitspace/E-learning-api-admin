<x-dashboard-layout>
    <x-slot:title>{{ translate('Language Manage') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Language" page-to="Language" />
    <div class="card overflow-hidden">

        @if ($languages->count() > 0)
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
                                {{ translate('Default') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('RTL') }}
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
                        @foreach ($languages as $language)
                            <tr>
                                <td class="px-3.5 py-4">{{ $language->name }}</td>
                                <td class="px-3.5 py-4">{{ $language->code }}</td>
                                <td class="px-3.5 py-4">
                                    <div class="form-check form-switch">
                                        <label class="inline-flex items-center me-5 cursor-pointer">
                                            <input type="checkbox" class="hidden appearance-none peer default-change"
                                                name="default"
                                                data-action="{{ route('language.default', $language->id) }}"
                                                {{ $language->active == 1 ? 'checked' : '' }}
                                                {{ $language->trashed() ? 'disabled' : '' }}>
                                            <span class="switcher switcher-primary-solid"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="form-check form-switch">
                                        <label class="inline-flex items-center me-5 cursor-pointer">
                                            <input type="checkbox" class="hidden appearance-none peer default-change"
                                                data-title="{{ $language->rtl == 1 ? translate('You want to Inactive RTL') : translate('You want to active RTL') }}"
                                                name="rtl" data-action="{{ route('language.rtl', $language->id) }}"
                                                {{ $language->rtl == 1 ? 'checked' : '' }}
                                                {{ $language->trashed() ? 'disabled' : '' }}>
                                            <span class="switcher switcher-primary-solid"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="form-check form-switch">
                                        <label class="inline-flex items-center me-5 cursor-pointer">
                                            <input type="checkbox" class="hidden appearance-none peer status-change"
                                                name="status"
                                                data-action="{{ route('language.status', $language->id) }}"
                                                {{ $language->status == 1 ? 'checked' : '' }}
                                                {{ $language->trashed() ? 'disabled' : '' }}>
                                            <span class="switcher switcher-primary-solid"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('site.language.translate', $language->id) }}"
                                            class="size-8 flex-center rounded-50 bg-info">
                                            <i class="ri-translate text-white text-base"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- START PAGINATION -->
            {{ $languages->links('portal::admin.pagination.paginate') }}
        @else
            <x-portal::admin.empty-card title="No language found" />
        @endif
    </div>
</x-dashboard-layout>
