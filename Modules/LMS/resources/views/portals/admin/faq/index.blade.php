<x-dashboard-layout>
    <x-slot:title>{{ translate('Manage Faq') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Faq List" page-to="Faq" action-route="{{ route('faq.create') }}" />

    @if ($faqs->count() > 0)
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary-500">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Question') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($faqs as $faq)
                            <tr>
                                <td class="px-3.5 py-4">
                                    {{ $faq->title }}
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('faq.edit', $faq->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-edit-2-line text-inherit text-base"></i>
                                        </a>
                                        <a href="{{ route('faq.show', $faq->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-eye-line text-inherit text-base"></i>
                                        </a>
                                        <button data-action="{{ route('faq.destroy', $faq->id) }}"
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
            {{ $faqs->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="Faq" action="{{ route('faq.create') }}"
            btnText="Add New" />
    @endif

</x-dashboard-layout>
