<x-dashboard-layout>
    <x-slot:title> {{ translate('Manage Notice Board') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Noticeboard" page-to="Noticeboard"
        action-route="{{ route('noticeboard.create') }}" />
    @if ($noticesBoards->count() > 0)
        <div class="card overflow-hidden">
            <div class="overflow-x-auto scrollbar-table">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Notice title') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Message') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Date') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($noticesBoards as $noticeBoard)
                            <tr>
                                <td class="px-3.5 py-4">{{ $noticeBoard->title }}</td>
                                <td class="px-3.5 py-4">
                                    <button class="btn b-light btn-info-light"
                                        data-modal-target="viewMassage{{ $noticeBoard->id }}"
                                        data-modal-toggle="viewMassage{{ $noticeBoard->id }}">{{ translate('View') }}</button>
                                    <div id="viewMassage{{ $noticeBoard->id }}" tabindex="-1"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-modal flex-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="p-4 w-full max-w-lg max-h-full">
                                            <div
                                                class="bg-white dark:bg-dark-card-shade rounded-lg dk-theme-card-square shadow">
                                                <div class="p-4 md:p-5 text-center">
                                                    <h5 class="card-title text-lg">{{ $noticeBoard->title }}</h5>
                                                    <div class="badge badge-disable-light inline-flex mt-1">
                                                        {{ customDateFormate($noticeBoard->created_at, $format = 'd M Y h:i A') }}
                                                    </div>
                                                    <div
                                                        class="text-gray-500 text-sm dark:text-dark-text text-pretty mt-5">
                                                        {!! clean($noticeBoard->description) !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ customDateFormate($noticeBoard->created_at, $format = 'd M Y h:i A') }}
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('noticeboard.edit', $noticeBoard->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-edit-2-line text-inherit text-base"></i>
                                        </a>
                                        <button data-action="{{ route('noticeboard.destroy', $noticeBoard->id) }}"
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
            {{ $noticesBoards->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="Noticeboard" action="{{ route('noticeboard.create') }}"
            btnText="Add New"></x-portal.admin.empty-card>
    @endif
</x-dashboard-layout>
