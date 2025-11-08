<x-dashboard-layout>
    <x-slot:title>{{ translate('Manage Contact') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="All Contact" page-to="Contact" />

    @if ($contacts->count() > 0)
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Name') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Email') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Message') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($contacts as $contact)
                            <tr class="">
                                <td class="px-3.5 py-4">
                                    {{ $contact->name }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ $contact->email }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ str_limit($contact->message ?? '', 30) }}
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('contact.view', $contact->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-message-2-line text-inherit text-base"></i>
                                        </a>
                                        <button data-action="{{ route('contact.delete', $contact->id) }}"
                                            class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"> <i
                                                class="ri-delete-bin-line text-inherit text-base"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Start Pagination -->
            {{ $contacts->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="Contact" btnText="Add New" />
    @endif
</x-dashboard-layout>
