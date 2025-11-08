<x-dashboard-layout>
    <x-slot:title> {{ translate('support-category') . '/' . translate('manage') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Support Category List" page-to="Support Category"
        action-route="{{ route('support-ticket.category.create') }}" />
    @if ($supportCategories->count() > 0)
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary-500">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Name') }}</th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($supportCategories as $category)
                            @php
                                $translations = parse_translation($category);
                            @endphp
                            <tr>
                                <td class="px-3.5 py-4">
                                    <h6 class="leading-none text-heading dark:text-white font-semibold">
                                        <a href="#">{{ $translations['name'] ?? $category->name }}</a>
                                    </h6>
                                </td>
                                <td class="px-3.5 py-4">

                                    <div class="flex items-center justify-end gap-1">

                                        <a href="{{ route('support-ticket.category.translate', ['id' => $category->id, 'locale' => app()->getLocale()]) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-translate text-inherit text-base"></i>
                                        </a>
                                        <a href="{{ route('support-ticket.category.edit', $category->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-edit-2-line text-inherit text-base"></i>
                                        </a>

                                        <a href="{{ route('support-ticket.category.show', $category->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-eye-line text-inherit text-base"></i>
                                        </a>
                                        <button
                                            data-action="{{ route('support-ticket.category.destroy', $category->id) }}"
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
            {{ $supportCategories->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="Support Category" action="{{ route('support-ticket.category.create') }}"
            btnText="Add New" />
    @endif
</x-dashboard-layout>
