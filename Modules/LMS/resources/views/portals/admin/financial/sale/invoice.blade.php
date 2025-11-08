@php
    $studentInfo = $invoice?->user->userable ?? null;
    $organization = $invoice?->course?->organization?->userable ?? null;

    $studentTranslations = parse_translation($studentInfo);
    $orgTranslations = parse_translation($organization);
    $course = $invoice->course;
    $instructors = $invoice?->course?->instructors ?? [];
    $general = get_theme_option('general') ?? [];
    $backendLogo = get_theme_option(key: 'backend_logo') ?? null;

    $invoiceLogo =
        isset($backendLogo['invoice_logo']) && fileExists('lms/theme-options', $backendLogo['invoice_logo']) == true
            ? asset("storage/lms/theme-options/{$backendLogo['invoice_logo']}")
            : asset('lms/assets/images/logo/logo.svg');

    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice- {{ $invoice->purchase_number }}</title>
    <link rel="stylesheet" href="{{ asset('lms/assets/css/output.min.css') }}">
</head>

<body>
    <div class="bg-white p-4">
        <div class="flex-center-between gap-5">
            <div class="shrink-0">
                <img src="{{ $invoiceLogo }}" alt="logo" class="w-36">
            </div>
            <div class="text-[#111827]/80 text-xl font-semibold">
                {{ translate('Item ID') }}: #{{ $invoice->course_id }}
            </div>
        </div>
        <div class="grid grid-cols-12 gap-7 mt-20">
            <div class="col-span-7">
                <div class="flex flex-col gap-2">
                    <div class="text-[#111827] font-medium">
                        <span class="font-bold">{{ translate('Student Name') }}:</span>
                        <span class="text-[#111827]/80">
                            {{ $studentTranslations['first_name'] ?? ($studentInfo->first_name ?? '') }}
                            {{ $studentTranslations['last_name'] ?? ($studentInfo->last_name ?? '') }}
                        </span>
                    </div>
                    <div class="text-[#111827] font-medium">
                        <span class="text-[#111827]/80">
                            <b> {{ translate('Student Phone') }}</b>: {{ $studentInfo->phone }}
                        </span>
                    </div>

                    <div class="text-[#111827] font-medium">
                        <span class="text-[#111827]/80">
                            <b> {{ translate('Student Email') }}</b>: {{ $invoice?->user?->email ?? '' }}
                        </span>
                    </div>

                    @if ($organization)
                        <div class="text-[#111827] font-medium">
                            <span class="font-bold">{{ translate('Organization') }}:</span>
                            <span
                                class="text-[#111827]/80">{{ $orgTranslations['name'] ?? ($organization->name ?? '') }}</span>
                        </div>
                    @endif

                    <div class="text-[#111827] font-medium">
                        <span class="font-bold">{{ translate('Instructor') }}:</span>
                        @foreach ($instructors as $instructor)
                            @php
                                $instructorTranslations = parse_translation($instructor->userable);
                            @endphp
                            <span
                                class="text-[#111827]/80">{{ $instructorTranslations['first_name'] ?? $instructor?->userable?->first_name }}
                                {{ $instructorTranslations['last_name'] ?? $instructor?->userable?->last_name }}
                            </span>
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-span-5">
                <div class="flex flex-col gap-2 text-right">
                    <div class="text-[#111827] font-medium">
                        <span class="font-bold">{{ translate('Address') }}:</span>
                        <span class="text-[#111827]/80">{{ $general['address'] ?? '' }}</span>
                    </div>
                    <div class="text-[#111827] font-medium">
                        <span class="font-bold">{{ translate('Purchase Date') }}:</span>
                        <span class="text-[#111827]/80">
                            {{ customDateFormate($invoice->created_at, format: 'd M y h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto mt-10">
            <table
                class="table-auto border-collapse w-full whitespace-nowrap text-center text-[#111827]/80 leading-none">
                <thead class="text-[#111827] font-bold">
                    <tr class="bg-[#111827]/5">
                        <th class="px-2 py-7 w-10 text-left">#</th>
                        <th class="px-2 py-7">{{ translate('Item') }}</th>
                        <th class="px-2 py-7">{{ translate('Type') }}</th>
                        <th class="px-2 py-7">{{ translate('Price') }}</th>
                        <th class="px-2 py-7">{{ translate('Discount Price') }}</th>
                        <th class="px-2 py-7">{{ translate('Total') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="last:border-b">
                        <td class="px-2 py-7">{{ $invoice?->course?->id ?? ($invoice?->courseBundle?->id ?? '') }}
                        </td>
                        <td class="px-2 py-7 max-w-56 text-wrap">
                            {{ $invoice?->course?->title ?? ($invoice?->courseBundle?->title ?? '') }}
                        </td>
                        <td class="px-2 py-7">{{ $invoice?->purchase_type }}</td>
                        <td class="px-2 py-7"> {{ $currencySymbol }}{{ $invoice?->price }}</td>
                        <td class="px-2 py-7"> {{ $currencySymbol }}{{ $invoice?->discount_price }}</td>
                        <td class="px-2 py-7">
                            @php
                                $subTotal = dotZeroRemove($invoice?->discount_price)
                                    ? $invoice?->discount_price
                                    : $invoice?->price;
                            @endphp
                            @if (dotZeroRemove($invoice?->discount_price))
                                {{ $currencySymbol }}{{ $invoice?->discount_price }}
                            @else
                                {{ $currencySymbol }}{{ $invoice?->price }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-end mt-10">
            <table class="w-[400px]">
                <tbody>
                    <tr class="last:border-t">
                        <td class="px-5 py-4">
                            <div class="text-[#111827] font-semibold !leading-none shrink-0">
                                {{ translate('Sub Total') }}:
                            </div>
                        </td>
                        <td class="px-5 py-4 w-10">
                            <div class="text-[#111827]/80 font-medium leading-none">${{ $subTotal }}</div>
                        </td>
                    </tr>

                    <tr class="last:border-t">
                        <td class="px-5 py-4">
                            <div class="text-[#111827] font-semibold !leading-none shrink-0">
                                {{ translate('Platform Fee') }}:
                            </div>
                        </td>
                        <td class="px-5 py-4 w-10">
                            <div class="text-[#111827]/80 font-medium leading-none">
                                {{ $currencySymbol }}{{ $invoice?->platform_fee }}
                            </div>
                        </td>
                    </tr>
                    <tr class="last:border-t">
                        <td class="px-5 py-4 bg-[#111827]/5">
                            <div class="text-[#111827] font-semibold !leading-none shrink-0">
                                {{ translate('Total') }}
                            </div>
                        </td>
                        <td class="px-5 py-4 bg-[#111827]/5 w-10">
                            <div class="text-[#111827]/80 font-bold leading-none">
                                {{ $currencySymbol }}{{ $subTotal + $invoice?->platform_fee }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset('lms/assets/js/vendor/jquery.min.js') }}"></script>
    <script>
        window.onload = function() {
            window.print();
        };
        window.onafterprint = function() {
            cancelPrint();
        };

        function cancelPrint() {
            window.close();
        }
    </script>
</body>

</html>
