<x-dashboard-layout>
    <x-slot:title>{{ translate('forum/manage') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Forum List" page-to="Forum" action-route="{{ route('forum.create') }}" />

    @if ($forums->count() > 0)
        <!-- Add Forum List -->
        <div class="card">
            <div class="overflow-x-auto scrollbar-table">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Title') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Sub Forum') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Posts') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Published Date') }}
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
                        @foreach ($forums as $forum)
                            <tr>
                                <td class="px-3.5 py-4">
                                    <h6 class="text-md leading-none">
                                        <a href="#">{{ $forum->title }}</a>
                                    </h6>
                                </td>
                                <td class="px-3.5 py-4">{{ $forum?->subForums?->count() }}</td>
                                <td class="px-3.5 py-4">{{ $forum?->forumPosts?->count() }}</td>
                                <td class="px-3.5 py-4">{{ customDateFormate($forum->updated_at, $format = 'y-m-d') }}
                                </td>
                                <td class="px-3.5 py-4 text-info">
                                    <label class="inline-flex items-center me-5 cursor-pointer">
                                        <input type="checkbox" class="appearance-none peer status-change" name="status"
                                            data-action="{{ route('forum.status', $forum->id) }}"
                                            {{ $forum->status == 1 ? 'checked' : '' }} role="switch">
                                        <span class="switcher switcher-primary-solid"></span>
                                    </label>
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('forum.edit', $forum->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-edit-2-line text-inherit text-base"></i>
                                        </a>
                                        <button class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                            data-action="{{ route('forum.destroy', $forum->id) }}">
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
    @else
        <x-portal::admin.empty-card title="Forum" action="{{ route('forum.create') }}"
            btnText="Add New"></x-portal::admin.empty-card>
    @endif
</x-dashboard-layout>
