<x-dashboard-layout>
    <x-slot:title> {{ translate('payment-method') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Payment Method List" page-to="Payment Method" />
    @if ($payments->count() > 0)
        <div class="card">
            <div class="overflow-x-auto scrollbar-table">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary-500">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Logo') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Method') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Mode') }}
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
                        @foreach ($payments as $payment)
                            @php
                                // Check if uploaded logo exists
                                if ($payment?->logo && fileExists('lms/payments', $payment?->logo) == true) {
                                    $paymentLogo = asset("storage/lms/payments/{$payment?->logo}");
                                } else {
                                    // Use method-specific default logos or fallback
                                    $defaultLogos = [
                                        'waafipay' => 'lms-waafipay.png'
                                    ];
                                    
                                    if (isset($defaultLogos[$payment->slug])) {
                                        $paymentLogo = asset('lms/frontend/assets/images/payment-method/' . $defaultLogos[$payment->slug]);
                                    } else {
                                        // Generic fallback for other payment methods
                                        $paymentLogo = asset('lms/frontend/assets/images/payment-method/master-card.webp');
                                    }
                                }
                            @endphp
                            <tr>
                                <td class="px-3.5 py-4">
                                    <div class="max-w-[100px] h-auto rounded-md overflow-hidden dk-theme-card-square">
                                        <img src="{{ $paymentLogo }}" alt="payment" class="max-w-[100px] max-h-10">
                                    </div>
                                </td>
                                <td class="px-3.5 py-4"> {{ $payment->method_name }} </td>
                                <td class="px-3.5 py-4">
                                    {!! $payment->enabled_test_mode == 1
                                        ? '<span class="form-label m-0">' . translate('Production') . '</span>'
                                        : '<span class="form-label m-0">' . translate('Sandbox') . '</span>' !!}
                                </td>
                                <td class="px-3.5 py-4 text-info">
                                    <label class="inline-flex items-center me-5 cursor-pointer">
                                        <input type="checkbox" class="appearance-none peer status-change" name="status"
                                            data-action="{{ route('payment.status', $payment->id) }}"
                                            {{ $payment->status == 1 ? 'checked' : '' }} role="switch">
                                        <span class="switcher switcher-primary-solid"></span>
                                    </label>
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('payment-method.edit', $payment->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-edit-2-line text-inherit text-base"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Start Pagination -->
                {{ $payments->links('portal::admin.pagination.paginate') }}
                <!-- End Pagination -->
            </div>
        </div>
    @else
        <x-portal::admin.empty-card title="Payment Method" action="{{ route('payment-method.create') }}"
            btnText="Add New" />
    @endif
</x-dashboard-layout>
