<x-dashboard-layout>
    <x-slot:title>{{ translate('forum/manage') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Sub Forum List" page-to="Sub Forum"
        action-route="{{ route('sub-forum.create') }}" />
    @if ($subForums->count() > 0)
        <div class="card p-0">
            <div class="p-3 sm:p-4">
                <div class="overflow-x-auto scrollbar-table">
                    <table
                        class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                        <thead class="text-primary">
                            <tr>
                                <th
                                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                    {{ translate('Title') }}</th>
                                <th
                                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                    {{ translate('Published Date') }}</th>
                                <th
                                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                    {{ translate('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                            @foreach ($subForums as $subForum)
                                <tr>
                                    <td class="px-3.5 py-4">
                                        <h6 class="text-md leading-none">
                                            <a href="#">{{ $subForum->name }}</a>
                                        </h6>
                                    </td>
                                    <td class="px-3.5 py-4">
                                        {{ customDateFormate($subForum->updated_at, $format = 'y-m-d') }}
                                    </td>
                                    <td class="px-3.5 py-4">
                                        <div class="flex items-center gap-1">
                                            <a href="{{ route('sub-forum.edit', $subForum->id) }}"
                                                class="btn-icon btn-primary-icon-light size-8">
                                                <i class="ri-edit-2-line text-inherit text-base"></i>
                                            </a>
                                            <button class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                                data-action="{{ route('sub-forum.destroy', $subForum->id) }}">
                                                <i class="ri-delete-bin-line text-inherit text-base"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <x-portal::admin.empty-card title="Sub Forum" action="{{ route('sub-forum.create') }}" btnText="Add New" />
    @endif
</x-dashboard-layout>
