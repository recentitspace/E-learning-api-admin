<x-dashboard-layout>
    <x-slot:title>{{ translate('Manage Staff') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Staff List" page-to="Staff" action-route="{{ route('staff.create') }}" />
    @if (!empty($staffs) || $staffs->count() > 0)
        <div class="card overflow-hidden">
            <div class="overflow-x-auto scrollbar-table">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary-500">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Profile Image') }}</th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Name') }}</th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Email') }}</th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Phone') }}</th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Roles') }}</th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($staffs as $staff)
                            <tr>
                                <td class="px-3.5 py-4">
                                    @if (fileExists('lms/admins', $staff->profile_img) == true && $staff->profile_img !== '')
                                        <img src="{{ asset('storage/lms/admins/' . $staff->profile_img) }}"
                                            alt="user-img" class="size-9 rounded-50 dk-theme-card-square object-cover">
                                    @else
                                        <img src="{{ asset('lms/assets/images/placeholder/profile.jpg') }}"
                                            alt="user-img" class="size-9 rounded-50 dk-theme-card-square object-cover">
                                    @endif
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $staff->name }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $staff->email }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $staff->phone }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ implode(',', $staff->roles->pluck('name')->toArray()) }}
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('staff.edit', $staff->id) }}"
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
            {{ $staffs->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="Staff" action="{{ route('staff.create') }}" btnText="Add New" />
    @endif
</x-dashboard-layout>
