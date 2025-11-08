<x-dashboard-layout>
    <x-slot:title> {{ translate('Notification History') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Notification History" page-to="Notification" />

    @if ($notifications->count() > 0)

        @php
            $statusRoute = 'instructor.notification.history.status';
            $deleteRoute = 'instructor.notification.history.delete';
        @endphp

        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
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
                                {{ translate('Message') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Date') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('View Status') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($notifications as $notification)
                            <tr>
                                <td class="px-4 py-4">{{ $notification?->data['title'] }}</td>
                                <td class="px-4 py-4">
                                    <div class="text-gray-500 dark:text-dark-text">
                                        {!! clean(isset($notification?->data['message']) ? $notification?->data['message'] : '') !!}
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    {{ $notification?->created_at?->diffForHumans(['options' => 0]) }}
                                </td>
                                <td class="px-4 py-4">

                                    <label class="inline-flex items-center me-5 cursor-pointer">
                                        <input type="checkbox" class="appearance-none peer status-change"
                                            name="status"{{ isset($notification?->read_at) ? 'checked' : '' }}
                                            data-action="{{ route($statusRoute, $notification->id) }}">
                                        <span class="switcher switcher-primary-solid"></span>
                                    </label>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <button data-action="{{ route($deleteRoute, $notification->id) }}"
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
            {{ $notifications->links('portal::admin.pagination.paginate') }}
            <!-- End Pagination -->
        </div>
    @else
        <x-portal::admin.empty-card title="No notification available" />
    @endif
</x-dashboard-layout>
