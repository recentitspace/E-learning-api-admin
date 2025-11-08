@php
    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
    $view = translate('View');
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ translate('Offline/manage') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Offline Payment" page-to="Payment" />
    <div class="card">
        @if ($offlinePayments->count() > 0)
            <div class="overflow-x-auto scrollbar-table">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('User') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Amount') }}
                            </th>

                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Document') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Date') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Status') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($offlinePayments as $offlinePayment)
                            @php
                                $user = $offlinePayment->user->userable ?? null;
                                $statusClass = '';
                                if ($offlinePayment->status == 'success') {
                                    $statusClass = 'badge-success-outline';
                                } elseif ($offlinePayment->status == 'pending') {
                                    $statusClass = 'badge-primary-outline';
                                } elseif ($offlinePayment->status == 'rejected') {
                                    $statusClass = 'badge-danger-outline';
                                }
                                $paymentDocument = $offlinePayment?->paymentDocument?->document ?? '';
                                $document =
                                    isset($paymentDocument) &&
                                    fileExists('lms/offline/documents', $paymentDocument) == true
                                        ? asset("storage/lms/offline/documents/{$paymentDocument}")
                                        : '';

                            @endphp
                            <td class="px-3.5 py-4">
                                {{ $user->first_name . ' ' . $user->last_name }}
                            </td>
                            <td class="px-3.5 py-4">
                                {{ $currencySymbol }}{{ $offlinePayment->total_amount }}
                            </td>
                            <td class="px-3.5 py-4">
                                <button data-modal-id="view-document{{ $offlinePayment->id }}"
                                    class="btn btn-primary-solid text-white"> {{ $view }}</button>
                                <div id="view-document{{ $offlinePayment->id }}"
                                    class="fixed inset-0 z-modal flex-center !hidden bg-black/50 modal">
                                    <div
                                        class="modal-content bg-white rounded-lg shadow-lg w-full max-w-screen-md transform transition-all duration-300 opacity-0 -translate-y-10 m-4">
                                        <!-- Modal Header -->
                                        <div class="flex items-center justify-between p-5 border-b">
                                            <button type="button" aria-label="Course demo video modal close button"
                                                class="absolute end-2.5 text-heading dark:text-white bg-gray-200 rounded-lg size-8 flex-center close-modal-btn demo-course-video-stop">
                                                <i class="ri-close-line text-inherit"></i>
                                            </button>
                                        </div>
                                        <!-- Modal Body -->
                                        <div class="p-4 pt-0 max-h-[80vh] overflow-auto">
                                            @if ($document)
                                                <img src="{{ $document }}" alt="">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3.5 py-4">
                                {{ customDateFormate($offlinePayment->created_at, $format = 'd M y h:i A') }}</td>
                            <td class="px-3.5 py-4">
                                <span
                                    class="badge b-outline {{ $statusClass }}">{{ translate($offlinePayment->status) }}
                                </span>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $offlinePayments->links('portal::admin.pagination.paginate') }}
        @else
            <x-portal::admin.empty-card title="No Offline Payment" />
        @endif
    </div>
</x-dashboard-layout>
