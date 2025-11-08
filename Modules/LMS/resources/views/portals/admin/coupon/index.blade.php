<x-dashboard-layout>
    <x-slot:title>{{ translate('Manage Coupon') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Coupon" page-to="Coupon" action-route="{{ route('coupon.create') }}" />
    @if ($coupons->count() > 0)
        <div class="card overflow-hidden">
            <!-- All Course coupon table -->
            <div class="overflow-x-auto">
                <table
                    class="table-auto border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium">
                    <thead>
                        <tr class="text-primary-500">
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Name') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Code') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Coupon Type') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Discount Type') }}
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
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td class="p-4">
                                    <h6 class="text-heading dark:text-white font-bold line-clamp-1"> {{ $coupon->name }}
                                    </h6>
                                </td>
                                <td class="p-4"> {{ $coupon->code }} </td>
                                <td class="p-4">{{ $coupon?->type }}</td>
                                <td class="p-4">{{ $coupon->discount_type }}</td>
                                <td class="p-4">
                                    <label class="inline-flex items-center me-5 cursor-pointer">
                                        <input type="checkbox" class="appearance-none peer  status-change"
                                            name="status" {{ $coupon->status == 1 ? 'checked' : '' }}
                                            data-action="{{ route('coupon.status', $coupon->id) }}">
                                        <span class="switcher switcher-primary-solid"></span>
                                    </label>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('coupon.edit', $coupon->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-edit-2-line text-inherit text-base"></i>
                                        </a>
                                        <button class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                            data-action="{{ route('coupon.destroy', $coupon->id) }}">
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
            {{ $coupons->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="Coupon" action="{{ route('coupon.create') }}" btnText="Add New" />
    @endif
</x-dashboard-layout>
