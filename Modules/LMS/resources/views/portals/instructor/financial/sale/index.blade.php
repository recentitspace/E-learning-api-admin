@php
    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ translate('Sale/manage') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Sale Report" page-to="Sale" />


    <div class="card">
        <div class="grid grid-cols-12 gap-4">
            <x-portal::admin.course-overview-card color-type="primary" title="Total Sale"
                value="{{ $currencySymbol }}{{ $reports['total_sales'] ?? 0 }}" />
            <x-portal::admin.course-overview-card color-type="warning" title="Platform Fee"
                value="{{ $currencySymbol }}{{ $reports['total_platform_fee'] ?? 0 }}" />
            <x-portal::admin.course-overview-card color-type="success" title="Total Course Sale"
                value="{{ $currencySymbol }}{{ $reports['total_course_sale'] ?? 0 }}" />
            <x-portal::admin.course-overview-card color-type="primary" title="Total Bundle Sale"
                value="{{ $currencySymbol }}{{ $reports['total_bundle_sale'] ?? 0 }}" />
        </div>
    </div>
    <div class="card">
        <div class="overflow-x-auto scrollbar-table">

            @if (count($sales) > 0)
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Purchase ID') }}
                            </th>

                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Student') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Instructor') }}
                            </th>

                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Platform Fee') }}
                            </th>

                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Discount Price') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Price') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Item') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Sales Type') }}
                            </th>

                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Purchase Date') }}
                            </th>


                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Payment Method') }}
                            </th>

                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Payment Status') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($sales as $sale)
                            @php
                                $studentInfo = $sale->user->userable ?? null;
                                $studentTranslations = [];
                                if ($studentInfo) {
                                    $studentTranslations = parse_translation($studentInfo);
                                }
                                $firstName = $studentTranslations['first_name'] ?? ($studentInfo?->first_name ?? '');
                                $lastName = $studentTranslations['last_name'] ?? ($studentInfo?->last_name ?? '');

                                $instructors = $sale->course->instructors ?? [];
                                $courseTranslations = parse_translation($sale?->course);
                                $bundleTranslations = parse_translation($sale?->courseBundle);

                                $courseTitle = $courseTranslations['title'] ?? $sale?->course?->title;
                                $bundleTitle = $bundleTranslations['title'] ?? $sale?->courseBundle?->title;

                                $itemId = $sale?->course->id ?? ($sale?->courseBundle?->id ?? 0);

                            @endphp
                            <tr>
                                <td class="px-3.5 py-4">
                                    #{{ $sale->purchase_number }}
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center gap-3.5">
                                        <div>
                                            <h6
                                                class="leading-none text-heading dark:text-white font-semibold capitalize">
                                                <a href="#">
                                                    {{ $firstName . ' ' . $lastName }}
                                                </a>
                                            </h6>
                                            <p class="mb-1 text-sm"> {{ $studentInfo?->user?->email }}</p>
                                            <p class="text-sm">{{ $studentInfo->phone }}</p>

                                        </div>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center gap-3.5">
                                        @foreach ($instructors as $instructor)
                                            @php
                                                $instructorInfo = $instructor->userable ?? null;
                                                $instructorTranslations = [];
                                                if ($studentInfo) {
                                                    $instructorTranslations = parse_translation($instructorInfo);
                                                }
                                                $firstName =
                                                    $instructorTranslations['first_name'] ??
                                                    ($studentInfo?->first_name ?? '');
                                                $lastName =
                                                    $instructorTranslations['last_name'] ??
                                                    ($studentInfo?->last_name ?? '');
                                            @endphp
                                            <div>
                                                <h6
                                                    class="leading-none text-heading dark:text-white font-semibold capitalize">
                                                    <a href="#"> {{ $firstName . ' ' . $lastName }} </a>
                                                </h6>
                                                <p class="mb-1 text-sm"> {{ $instructorInfo?->user?->email }}</p>
                                                <p class="text-sm">{{ $instructorInfo->phone }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-3.5 py-4"> {{ $currencySymbol }}{{ $sale?->platform_fee }}</td>
                                <td class="px-3.5 py-4"> {{ $currencySymbol }}{{ $sale?->discount_price }}</td>
                                <td class="px-3.5 py-4">
                                    @if ($sale?->price)
                                        {{ $currencySymbol }}{{ $sale?->price }}
                                    @else
                                        {{ translate('Free') }}
                                    @endif
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ str_limit($courseTitle ?? $bundleTitle, 20) }}
                                    <p class="text-sm mt-1"> {{ translate('Item Id') }} :#{{ $itemId }}</p>
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ translate($sale->purchase_type ?? '') }}
                                </td>
                                <td class="px-3.5 py-4">
                                    {{ customDateFormate($sale->updated_at, $format = 'd M y h:i A') }}</td>
                                <td class="px-3.5 py-4"> {{ translate($sale?->purchase?->payment_method) }}</td>
                                <td class="px-3.5 py-4"> {{ translate($sale?->purchase?->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <x-portal::admin.empty-card title="No Sale Course" />
            @endif
        </div>
    </div>
</x-dashboard-layout>
