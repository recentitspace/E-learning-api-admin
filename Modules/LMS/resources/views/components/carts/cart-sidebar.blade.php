@php
    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp

<div class="col-span-full lg:col-span-4">
    <div class="bg-primary-50 p-6 rounded-xl">
        <form class="get-form" method="get" action="{{ route('apply.coupon') }}">
            <h6 class="text-xl text-heading dark:text-white !leading-none font-bold">
                {{ translate('Coupon Code') }}
            </h6>
            <div class="flex mt-4">
                <input type="text" placeholder="{{ translate('Coupon Code') }}" id="coupon_code"
                    class="bg-white text-heading dark:text-white h-12 rounded-r-none rounded-l-full rtl:rounded-l-none rtl:rounded-r-full px-4 focus:outline-none w-full max-w-full grow">
                <button type="submit"
                    class="btn b-solid btn-primary-solid rounded-l-none rtl:rounded-l-full rounded-r-full rtl:rounded-r-none">
                    {{ translate('Apply') }}
                </button>
            </div>
        </form>
        <table class="w-full my-7">
            <caption class="text-xl text-heading dark:text-white !leading-none font-bold text-left rtl:text-right mb-5">
                {{ translate('Cart Total') }}
            </caption>
            <tbody class="divide-y divide-border border-t border-border">
                <tr>
                    <td class="px-1 py-4 text-left rtl:text-right">
                        <div class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                            <span class="text-heading dark:text-white mb-0.5">
                                {{ translate('Subtotal') }}
                            </span>
                        </div>
                    </td>
                    <td class="px-1 py-4 text-right rtl:text-left">
                        <div class="text-heading/70 font-semibold leading-none" id="subTotal">
                            {{ $currencySymbol }}{{ $data['totalPrice'] }}
                        </div>
                    </td>
                </tr>
                <tr id="discount-area">
                    @if ($data['discountAmount'])
                        <td class="px-1 py-4 text-left rtl:text-right">
                            <div
                                class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                                <span class="text-heading dark:text-white mb-0.5">{{ translate('Discount') }} (-)</span>
                            </div>
                        </td>
                        <td class="px-1 py-4 text-right rtl:text-left" id="discount-area">
                            <div class="text-heading/70 font-semibold leading-none">
                                {{ $currencySymbol }}{{ $data['discountAmount'] }}</div>
                        </td>
                    @endif
                </tr>
                <tr>
                    <td class="px-1 py-4 text-left rtl:text-right">
                        <div class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                            <span class="text-heading dark:text-white text-lg font-bold mb-0.5">
                                {{ translate('Total') }}
                            </span>
                        </div>
                    </td>
                    <td class="px-1 py-4 text-right rtl:text-left">
                        <div class="text-primary text-lg font-bold leading-none" id="grand_total">
                            @php
                                $totalPrice = $data['discountAmount']
                                    ? $data['totalPrice'] - $data['discountAmount']
                                    : $data['totalPrice'];
                            @endphp
                            {{ $currencySymbol }}{{ $totalPrice }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        @if (authCheck())
            <a href="{{ route('checkout.page') }}" aria-label="Checkout"
                class="btn b-solid btn-primary-solid btn-xl !rounded-full w-full h-12">
                {{ translate('Checkout') }}
                <i class="ri-arrow-right-line rtl:before:content-['\ea60'] text-[20px]"></i>
            </a>
        @else
            <a href="#" class="btn b-solid btn-primary-solid btn-xl !rounded-full w-full h-12 auth-login"
                aria-label="Checkout">
                {{ translate('Checkout') }}
                <i class="ri-arrow-right-line rtl:before:content-['\ea60'] text-[20px]"></i>
            </a>
        @endif
    </div>
</div>
