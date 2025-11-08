@php
    $locale = request()->locale ?? app()->getLocale();
    $translations = [];
    $bundle = $bundle ?? null;
    if ($bundle && $locale) {
        $translations = parse_translation($bundle, $locale);
    }
    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $platformFee = $backendSetting['platform_fee'] ?? 0;
    $bundlePrice = isset($bundle) ? $bundle->price - $bundle->platform_fee : null;
    $isOrganization = isOrganization();
    $isAdmin = isAdmin();
@endphp


<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="pricing">
        @csrf
        <input type="hidden" name="bundle_id" class="bundleId" value="{{ $bundle->id ?? '' }}">
        <div class="grid grid-cols-12 gap-4 card">
            <div class="col-span-full lg:col-span-2">
                <div class="mt-6">
                    <label for="currency" class="form-label">{{ translate('Currency') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select data-select id="currency" name="currency" class="singleSelect">
                        <option selected disabled data-display="{{ translate('Select Currency') }}">
                            {{ translate('Select Currency') }} </option>
                        @foreach (all_currency() as $currency)
                            @php
                                $codeSymbol = $currency->code . '-' . $currency->symbol;
                            @endphp
                            <option value="{{ $currency->code . '-' . $currency->symbol }}"
                                {{ isset($bundle) && $bundle?->currency == $codeSymbol ? 'selected' : '' }}>
                                {{ $currency->symbol }} - {{ $currency->code }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text currency_err"></span>
                </div>
            </div>
            <div class="col-span-full lg:col-span-3">
                <div class="mt-6">
                    <label for="price" class="form-label"> {{ translate('Price') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="number" placeholder="{{ translate('Your Price') }}"
                        class="form-input bundle-price-cal" value="{{ $bundlePrice ?? '' }}" id="price">
                </div>
            </div>
            <div class="col-span-full lg:col-span-3">
                <div class="mt-6">
                    <label for="platform_fee" class="form-label">
                        {{ translate('Platform Price') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="hidden"value="{{ $platformFee ?? '' }}" name="platform_fee">
                    <input type="number" id="platform_fee" placeholder="{{ translate('Platform Price') }}" disabled
                        class="form-input disabled:!text-heading" value="{{ $platformFee ?? '' }}"
                        placeholder="Platform Price">
                    <span class="text-danger error-text platform_fee_err"></span>
                </div>
            </div>
            <div class="col-span-full lg:col-span-3">
                <div class="mt-6">
                    <label for="total_price" class="form-label">{{ translate('Total Price') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <input type="number" id="total_price" placeholder="{{ translate('Bundle Price') }}" name="price"
                        class="form-input" value="{{ $bundlePrice + $platformFee ?? '' }}">
                    <span class="text-danger error-text  price_err"></span>
                </div>
            </div>
        </div>
        <div class="card flex-center gap-4 justify-end">
            <button type="button" class="prev-form-btn btn b-outline btn-primary-outline">
                {{ translate('Previous') }}
            </button>
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }}
            </button>
        </div>
    </form>
</div>
