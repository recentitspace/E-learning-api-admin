@php
    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
    $cartType = session()->has('type') ? session()->get('type') : '';
@endphp

@push('css')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script async src="https://sandbox.doku.com/jokul-checkout-js/v1/jokul-checkout-1.0.0.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
@endpush

<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="Checkout" pageRoute="{{ route('checkout.page') }}"
        pageName="Checkout" />
    <div class="container">
        @csrf
        <div class="grid grid-cols-12 gap-5">
            <!-- START FILTER SIDEBAR -->
            <div class="col-span-full lg:col-span-8">
                <h2 class="area-title xl:text-3xl mb-5">{{ translate('Payment Method') }}</h2>
                <div class="dashkit-tab flex flex-wrap items-center gap-2.5" id="paymentMethodTab">
                    @foreach (get_payment_method() as $payment)
                        @php
                            // Check if uploaded logo exists
                            if ($payment->logo && fileExists('lms/payments', $payment->logo) == true) {
                                $logo = asset('storage/lms/payments/' . $payment->logo);
                            } else {
                                // Use method-specific default logos or fallback
                                $defaultLogos = [
                                    'waafipay' => 'lms-waafipay.png'
                                ];
                                
                                if (isset($defaultLogos[$payment->slug])) {
                                    $logo = asset('lms/frontend/assets/images/payment-method/' . $defaultLogos[$payment->slug]);
                                } else {
                                    // Generic fallback for other payment methods
                                    $logo = asset('lms/frontend/assets/images/payment-method/master-card.webp');
                                }
                            }
                        @endphp
                        <button
                            class="dashkit-tab-btn btn border border-border btn-lg !px-8 h-14 !rounded-full [&.active]:border-primary payment-item"
                            data-method="{{ strtolower($payment->method_name) }}"
                            data-action ="{{ route('payment.form') }}">
                            <img data-src="{{ $logo }}" alt="master card" class="w-20">
                        </button>
                    @endforeach
                </div>
                <div class="dashkit-tab-content mt-[60px]" id="paymentMethodTabContent">
                    <!-- MASTER CARD FORM -->
                    <div class="dashkit-tab-pane">
                        <x-theme::cards.empty title="Select Payment" />
                    </div>
                </div>
            </div>
            <!-- END FILTER SIDEBAR -->

            <!-- START TOTAL -->
            <div class="col-span-full lg:col-span-4">
                <div class="bg-primary-50 p-6 rounded-xl">
                    <h6 class="text-3xl text-heading dark:text-white !leading-none font-bold">
                        {{ translate('Your Order') }}
                    </h6>
                    <table class="w-full my-7">
                        @if ($cartType !== 'subscription')
                            <caption
                                class="text-xl text-heading dark:text-white !leading-none font-bold text-left rtl:text-right mb-5">
                                {{ translate('Cart Total') . ' ' . total_qty() }}
                            </caption>
                        @endif
                        <tbody class="divide-y divide-border border-t border-border">
                            <tr>
                                <td class="px-1 py-4 text-left rtl:text-right">
                                    <div
                                        class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                                        <span
                                            class="text-heading dark:text-white mb-0.5">{{ translate('Subtotal') }}</span>
                                    </div>
                                </td>
                                <td class="px-1 py-4 text-right rtl:text-left">
                                    <div class="text-heading/70 font-semibold leading-none">
                                        {{ $currencySymbol }}{{ number_format($data['totalPrice'], 2) ?? null }}
                                    </div>
                                </td>
                            </tr>
                            @if ($data['discountAmount'])
                                <tr>
                                    <td class="px-1 py-4 text-left rtl:text-right">
                                        <div
                                            class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                                            <span
                                                class="text-heading dark:text-white mb-0.5">{{ translate('Discount') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-1 py-4 text-right rtl:text-left">
                                        <div class="text-heading/70 font-semibold leading-none">
                                            {{ $currencySymbol }}{{ $data['discountAmount'] }}</div>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td class="px-1 py-4 text-left rtl:text-right">
                                    <div
                                        class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                                        <span
                                            class="text-heading dark:text-white text-lg font-bold mb-0.5">{{ translate('Total') }}</span>
                                    </div>
                                </td>
                                <td class="px-1 py-4 text-right rtl:text-left">
                                    <div class="text-primary text-lg font-bold leading-none">
                                        @php
                                            $totalPrice = $data['discountAmount']
                                                ? $data['totalPrice'] - $data['discountAmount']
                                                : $data['totalPrice'];
                                        @endphp
                                        {{ $currencySymbol }}{{ number_format($totalPrice, 2) }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="pay-button">

                    </div>
                </div>
            </div>
            <!-- END TOTAL -->
        </div>
    </div>
    <!-- END INNER CONTENT AREA -->
</x-frontend-layout>
