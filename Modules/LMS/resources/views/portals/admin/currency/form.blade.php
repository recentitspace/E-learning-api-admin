<x-dashboard-layout>
    <x-slot:title>{{ isset($currency) ? translate('Edit') : translate('Create') }} {{ translate('Currency') }}
    </x-slot:title>
    <x-portal::admin.breadcrumb back-url="{{ route('currency.index') }}"
        title="{{ isset($currency) ? 'Edit' : 'Create' }}" page-to="Currency" />
    <form action="{{ isset($currency) ? route('currency.update', $currency->id) : route('currency.store') }}"
        method="post" class="form mb-4">
        @csrf
        @if (isset($currency))
            @method('PUT')
        @endif
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6 card">
                <div class="leading-none mt-6">
                    <label for="currency" class="form-label">{{ translate('Currency') }}</label>
                    <select data-select id="currency" name="currency" class="singleSelect">
                        <option selected disabled data-display="{{ translate('Select Currency') }}">
                            {{ translate('Select Currency') }} </option>
                        @foreach (get_currency_list() as $currencyList)
                            <option
                                value="{{ $currencyList['symbol'] . '-' . $currencyList['code'] . '-' . $currencyList['name'] }}"
                                {{ isset($currency) && $currencyList['code'] == $currency->code ? 'selected' : '' }}>
                                {{ $currencyList['symbol'] }} - {{ $currencyList['code'] }}
                            </option>
                        @endforeach
                    </select>
                    <div class="justify-end mt-3">
                        <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                            {{ isset($currency) ? translate('Update') : translate('Save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-dashboard-layout>
