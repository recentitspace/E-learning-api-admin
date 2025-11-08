@php
    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ translate('Payout/manage') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Payout Request" page-to="Payout" />

    <div class="card">
        <div class="grid grid-cols-12 gap-4">
            <x-portal::admin.course-overview-card color-type="primary" title="Total Request Amount"
                value="{{ $currencySymbol }}{{ $reports['total_request_amount'] ?? 0 }}" />
            <x-portal::admin.course-overview-card color-type="warning" title="Total Pending Amount"
                value="{{ $currencySymbol }}{{ $reports['total_pending_amount'] ?? 0 }}" />
            <x-portal::admin.course-overview-card color-type="success" title="Total Paid Amount"
                value="{{ $currencySymbol }}{{ $reports['total_paid_amount'] ?? 0 }}" />
        </div>
    </div>

    <div class="card">
        @if ($payoutRequests->count() > 0)
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
                                {{ translate('User') }}
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
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Status') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($payoutRequests as $payoutRequest)
                            @php
                                $userInfo = $payoutRequest->user->userable ?? null;
                                $userTranslations = [];
                                $designationTranslations = [];
                                if ($userInfo) {
                                    $userTranslations = parse_translation($userInfo);
                                }
                                $firstName = $userTranslations['first_name'] ?? ($userInfo?->first_name ?? '');
                                $lastName = $userTranslations['last_name'] ?? ($userInfo?->last_name ?? '');
                                $name = $userTranslations['name'] ?? ($userInfo?->name ?? '');
                            @endphp
                            <tr>
                                <td class="px-3.5 py-4">
                                    <h6 class="text-md leading-none"> <a
                                            href="#">#{{ $payoutRequest->payout_number }}</a> </h6>
                                </td>
                                <td class="px-3.5 py-4">
                                    <h6 class="text-md leading-none">
                                        <p class="mb-1"> <b>{{ translate('Name') }}</b> :@if (isset($userInfo?->first_name, $userInfo?->last_name))
                                                {{ $firstName }}
                                                {{ $lastName }}
                                            @else
                                                {{ $name }}
                                            @endif
                                        </p>
                                        <p class="mb-1 text-sm"> {{ $payoutRequest?->user?->email }}</p>
                                        <p class="text-sm"> {{ $userInfo->phone }}</p>
                                    </h6>
                                </td>
                                <td class="px-3.5 py-4">{{ $currencySymbol }}{{ $payoutRequest->amount }}</td>
                                <td class="px-3.5 py-4">
                                    {{ customDateFormate($payoutRequest->created_at, $format = 'd M y h:i A') }}</td>
                                <td class="px-3.5 py-4">
                                    @if ($payoutRequest->status == 'approved')
                                        <span class="badge b-outline badge-success-outline">
                                            {{ translate($payoutRequest->status) }}</span>
                                    @else
                                        <select name="status" class="select-status-change form-input form-select"
                                            data-action="{{ route('payout.status', ['id' => $payoutRequest->id]) }}">
                                            <option selected disabled>{{ translate('Selected status Payout') }}
                                            </option>
                                            <option value="pending"
                                                {{ $payoutRequest->status == 'pending' ? 'selected' : '' }}>
                                                {{ translate('Pending') }}</option>
                                            <option value="approved"
                                                {{ $payoutRequest->status == 'approved' ? 'selected' : '' }}>
                                                {{ translate('Approved') }}</option>
                                        </select>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $payoutRequests->links('portal::admin.pagination.paginate') }}
        @else
            <x-portal::admin.empty-card title="No Payout Request" />
        @endif
    </div>
</x-dashboard-layout>
