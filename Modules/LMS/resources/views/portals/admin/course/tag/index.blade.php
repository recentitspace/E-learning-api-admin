<x-dashboard-layout>
    <x-slot:title>{{ translate('Manage Tag') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Tag" page-to="Tag" action-route="{{ route('tag.create') }}" />
    @if ($tags->count() > 0)
        <div class="card overflow-hidden">
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
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($tags as $tag)
                            @php $translations = parse_translation($tag); @endphp
                            <tr>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <h6 class="leading-none text-heading dark:text-white font-semibold">
                                                <a href="#">{{ $translations['name'] ?? $tag->name ?? '' }}</a>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('tag.translate', ['id' => $tag->id, 'locale' => app()->getLocale()]) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-translate text-inherit text-base"></i>
                                        </a>
                                        <a href="{{ route('tag.edit', $tag->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-edit-2-line text-inherit text-base"></i>
                                        </a>

                                        <a href="{{ route('tag.show', $tag->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-eye-line text-inherit text-base"></i>
                                        </a>

                                        <button class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                            data-action="{{ route('tag.destroy', $tag->id) }}">
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
            {{ $tags->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="No Tag" action="{{ route('tag.create') }}"
            btnText="Add New" />
    @endif
</x-dashboard-layout>
