@php
    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp


<x-dashboard-layout>
    <x-slot:title>{{ translate('Payout/manage') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Payout Report" page-to="Payout" />
    <div class="card">
        <div class="grid grid-cols-12 gap-4">
            <x-portal::admin.course-overview-card color-type="primary" title="Total Request Amount"
                value="{{ $currencySymbol }}{{ $reports['total_request_amount'] ?? 0 }}" />
            <x-portal::admin.course-overview-card color-type="info" title="Total Pending Amount"
                value="{{ $currencySymbol }}{{ $reports['total_pending_amount'] ?? 0 }}" />
            <x-portal::admin.course-overview-card color-type="success" title="Total Paid Amount"
                value="{{ $currencySymbol }}{{ $reports['total_paid_amount'] ?? 0 }}" />

            <x-portal::admin.course-overview-card title="Available Payout Amount"
                value="{{ $currencySymbol }}{{ authcheck()->userable?->user_balance ?? 0 }}" />
        </div>
    </div>
    <div class="card flex justify-end">
        <button type="button" data-modal-id="demo-video-modal"
            class="btn b-solid btn-primary-solid dk-theme-card-square">
            {{ translate('Request Payout') }}
        </button>
    </div>
    <div class="card">
        @if ($payoutHistories->count() > 0)
            <div class="overflow-x-auto scrollbar-table">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Payout ID') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Amount') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Date') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Status') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($payoutHistories as $payoutHistory)
                            <tr>
                                <td class="px-3.5 py-4">
                                    <h6 class="text-md leading-none"> <a
                                            href="#">{{ $payoutHistory->payout_number }}</a> </h6>
                                </td>
                                <td class="px-3.5 py-4">{{ $currencySymbol }}{{ $payoutHistory->amount }}</td>
                                <td class="px-3.5 py-4">
                                    {{ customDateFormate($payoutHistory->created_at, $format = 'd M y h:i A') }}</td>
                                <td class="px-3.5 py-4">{{ translate($payoutHistory->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $payoutHistories->links('portal::admin.pagination.paginate') }}
        @else
            <x-portal::admin.empty-card title="No Payout Request" />
        @endif
    </div>
    <div id="demo-video-modal" class="fixed inset-0 z-modal flex-center !hidden bg-black/50 modal">
        <div
            class="modal-content bg-white rounded-lg shadow-lg w-full max-w-screen-md transform transition-all duration-300 opacity-0 -translate-y-10 m-4">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <div>
                    <div class="area-subtitle">
                        {{ translate('Payout Confirmation') }}
                    </div>
                </div>
                <button type="button" aria-label="Course demo video modal close button"
                    class="absolute top-3 end-2.5 text-heading dark:text-white bg-gray-200 rounded-lg size-8 flex-center close-modal-btn demo-course-video-stop">
                    <i class="ri-close-line text-inherit"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-4 pt-0 max-h-[80vh] overflow-auto">
                <form action="{{ route('organization.payout.request') }}" method="post" class="form">
                    @csrf
                    <div class="grid grid-cols-12 gap-x-4">
                        <div class="col-span-full md:col-span-8 card">
                            <div class="flex justify-center gap-3">
                                <div>
                                    <h2>{{ translate('Available Amount') }}</h2>
                                </div>
                                <div>
                                    <strong>
                                        {{ $currencySymbol }}{{ authcheck()->userable?->user_balance ?? 0 }}</strong>
                                </div>
                            </div>
                            <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                                {{ translate('Request') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
