@php
    $editRoute = 'noticeboard.edit';
    $deleteRoute = 'noticeboard.destroy';

    $isInstructor = isInstructor();
    $isOrganization = isOrganization();
    if ($isInstructor) {
        $editRoute = 'instructor.noticeboard.edit';
        $deleteRoute = 'instructor.noticeboard.destroy';
    }
    if ($isOrganization) {
        $editRoute = 'organization.noticeboard.edit';
        $deleteRoute = 'organization.noticeboard.destroy';
    }
@endphp

<div class="overflow-x-auto scrollbar-table">
    <table
        class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
        <thead class="text-primary-500">
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
                        <button class="btn b-light btn-info-light btn-sm dk-theme-card-square"
                            data-modal-target="viewMassage{{ $noticeBoard->id }}"
                            data-modal-toggle="viewMassage{{ $noticeBoard->id }}">{{ translate('View') }}</button>
                        <!-- Start Massage Modal -->
                        <div id="viewMassage{{ $noticeBoard->id }}" tabindex="-1"
                            class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-modal flex-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="p-4 w-full max-w-lg max-h-full">
                                <div class="bg-white dark:bg-dark-card-shade rounded-lg dk-theme-card-square shadow">
                                    <div class="p-4 md:p-5 text-center">
                                        <h5 class="card-title text-lg mb-2">{{ $noticeBoard->title }}</h5>
                                        <span class="badge badge-disable-light inline-flex mb-2">
                                            {{ customDateFormate($noticeBoard->created_at, $format = 'd M Y h:i A') }}</span>
                                        <p class="text-gray-500 dark:text-dark-text text-pretty">{!! clean($noticeBoard->description ?? '') !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- End Massage Modal -->
                    </td>
                    <td class="px-3.5 py-4">
                        {{ customDateFormate($noticeBoard->created_at, $format = 'd M Y h:i A') }}</td>
                    <td class="px-3.5 py-4">

                        <div class="flex items-center gap-1">
                            <a href="{{ route($editRoute, $noticeBoard->id) }}"
                                class="btn-icon btn-primary-icon-light size-8">
                                <i class="ri-edit-2-line text-inherit text-base"></i>
                            </a>
                            <button data-action="{{ route($deleteRoute, $noticeBoard->id) }}"
                                class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"> <i
                                    class="ri-delete-bin-line text-inherit text-base"></i> </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
