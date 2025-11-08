<x-dashboard-layout>
    <x-slot:title> {{ translate('Create Method') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('payment-method.index') }}"
        title="{{ isset($method) ? 'Edit' : 'Create' }} Payment Method" page-to="Payment Method" />


    <div class="card">

        @if(isset($method))
        <div>
            <b> {{ translate(ucfirst($method->slug) . ' Setting') }}</b>
        </div>
        @endif
        <form method="post" class="form"
            action="{{ isset($method) ? route('payment-method.update', $method->id) : route('payment-method.store') }}">
            @csrf
            @if (isset($method))
                @method('PUT')
            @endif

            @if(isset($method))
            <div class="mt-6 grid grid-cols-12 gap-4">
                <div class="col-span-full md:col-span-4 mt-3">
                    <label class="form-label"> {{ translate('Want to keep test mode enabled') }}?</label>
                    <select name="enabled_test_mode" class="form-input">
                        <option value="0" {{ $method->enabled_test_mode == 0 ? 'selected' : '' }}>
                            {{ translate('Sandbox') }}</option>
                        <option value="1" {{ $method->enabled_test_mode == 1 ? 'selected' : '' }}>
                            {{ translate('Production') }}
                        </option>
                    </select>
                </div>
                <div class="col-span-full md:col-span-4 mt-3">
                    <label class="form-label"> {{ translate('Status') }}</label>
                    <select name="status" class="form-input">
                        <option value="1" {{ $method->status == 1 ? 'selected' : '' }}>
                            {{ translate('Active') }}</option>
                        <option value="0" {{ $method->status == 0 ? 'selected' : '' }}>
                            {{ translate('Inactive') }}
                        </option>
                    </select>
                </div>
                <div class="col-span-full md:col-span-4 mt-3">
                    <label class="form-label"> {{ translate('Select Currency') }} </label>
                    <select data-select id="currency" name="currency" class="singleSelect">
                        <option selected disabled data-display="{{ translate('Select Currency') }}">
                            {{ translate('Select Currency') }} </option>
                        @foreach (get_currency_list() as $currencyList)
                            <option value="{{ $currencyList['code'] }}"
                                {{ $currencyList['code'] == $method->currency ? 'selected' : '' }}>
                                {{ $currencyList['code'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if (isset($method) && $method->slug == 'paypal')
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Sandbox Client') }}</label>
                            <input type="text" placeholder="{{ translate('Sandbox Client Id') }}"
                                name="key[0][sandbox_client_id]" value="{{ $method->keys['sandbox_client_id'] ?? '' }}"
                                class="form-input">
                        </div>
                    </div>
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Sandbox Secret') }}</label>
                            <input type="text" placeholder="{{ translate('Sandbox Secret Key') }}"
                                name="key[0][sandbox_secret_key]"
                                value="{{ $method->keys['sandbox_secret_key'] ?? '' }}" class="form-input">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Production Client') }}</label>
                            <input type="text" placeholder="{{ translate('Production Client Id') }}"
                                name="key[0][production_client_id]"
                                value="{{ $method->keys['production_client_id'] ?? '' }}" class="form-input">
                        </div>
                    </div>
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Production Secret') }}</label>
                            <input type="text" placeholder="{{ translate('Production Secret Key') }}"
                                name="key[0][production_secret_key]"
                                value="{{ $method->keys['production_secret_key'] ?? '' }}" class="form-input">
                        </div>
                    </div>
                </div>
            @endif

            @if (isset($method) && $method->slug == 'stripe')
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Public key') }}</label>
                            <input type="text" placeholder="{{ translate('Public Key') }}" name="key[0][public_key]"
                                value="{{ $method->keys['public_key'] ?? '' }}" class="form-input">
                        </div>
                    </div>
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Secret Key') }}</label>
                            <input type="text" placeholder="{{ translate('Secret Key') }}" name="key[0][secret_key]"
                                value="{{ $method->keys['secret_key'] ?? '' }}" class="form-input">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Live Public key') }}</label>
                            <input type="text" placeholder="{{ translate('Live Public key') }}"
                                name="key[0][public_live_key]" value="{{ $method->keys['public_live_key'] ?? '' }}"
                                class="form-input">
                        </div>
                    </div>
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Live Secret') }}</label>
                            <input type="text" placeholder="{{ translate('Live Secret Key') }}"
                                name="key[0][secret_live_key]" value="{{ $method->keys['secret_live_key'] ?? '' }}"
                                class="form-input">
                        </div>
                    </div>
                </div>
            @endif
            @if (isset($method) && $method->slug == 'razorpay')
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Key Id') }}</label>
                            <input type="text" placeholder="{{ translate('Key Id') }}" name="key[0][key_id]"
                                value="{{ $method->keys['key_id'] ?? '' }}" class="form-input">
                        </div>
                    </div>
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Secret Key') }}</label>
                            <input type="text" placeholder="{{ translate('Secret Key') }}" name="key[0][secret_key]"
                                value="{{ $method->keys['secret_key'] ?? '' }}" class="form-input">
                        </div>
                    </div>
                </div>
            @endif

            @if (isset($method) && $method->slug == 'paystack')
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Public Key') }}</label>
                            <input type="text" placeholder="{{ translate('Public Key') }}"
                                name="key[0][public_key]" value="{{ $method->keys['public_key'] ?? '' }}"
                                class="form-input">
                        </div>
                    </div>
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Secret Key') }}</label>
                            <input type="text" placeholder="{{ translate('Secret Key') }}"
                                name="key[0][secret_key]" value="{{ $method->keys['secret_key'] ?? '' }}"
                                class="form-input">
                        </div>
                    </div>

                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Merchant Email') }}</label>
                            <input type="text" placeholder="{{ translate('Merchant Email') }}"
                                name="key[0][merchant_email]" value="{{ $method->keys['merchant_email'] ?? '' }}"
                                class="form-input">
                        </div>
                    </div>
                </div>
            @endif



            {{-- PAYSTACK_PUBLIC_KEY=pk_test_4b1846ca234d7f4afef52108edd83fa5f8783bac
            PAYSTACK_SECRET_KEY=sk_test_f4962ee5001b525e99b83e1f8e4fcc90782f9d0d
            PAYSTACK_PAYMENT_URL=https://api.paystack.co
            MERCHANT_EMAIL=alam.csfs@gmail.com --}}


            @if (isset($method) && $method->slug == 'waafipay')
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Merchant UID') }}</label>
                            <input type="text" placeholder="{{ translate('Merchant UID') }}" name="key[0][merchant_uid]"
                                value="{{ $method->keys['merchant_uid'] ?? '' }}" class="form-input">
                        </div>
                    </div>
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('API User ID') }}</label>
                            <input type="text" placeholder="{{ translate('API User ID') }}" name="key[0][api_user_id]"
                                value="{{ $method->keys['api_user_id'] ?? '' }}" class="form-input">
                        </div>
                    </div>
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('API Key') }}</label>
                            <input type="text" placeholder="{{ translate('API Key') }}" name="key[0][api_key]"
                                value="{{ $method->keys['api_key'] ?? '' }}" class="form-input">
                        </div>
                    </div>
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Payment Method') }}</label>
                            <select name="key[0][payment_method]" class="form-input">
                                <option value="MWALLET_ACCOUNT" {{ ($method->keys['payment_method'] ?? '') == 'MWALLET_ACCOUNT' ? 'selected' : '' }}>
                                    {{ translate('Mobile Wallet Account') }}
                                </option>
                                <option value="MWALLET_BANKACCOUNT" {{ ($method->keys['payment_method'] ?? '') == 'MWALLET_BANKACCOUNT' ? 'selected' : '' }}>
                                    {{ translate('Mobile Wallet Bank Account') }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            @endif

            @if (isset($method) && $method->slug == 'xendit')
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('API Key') }}</label>
                            <input type="text" placeholder="{{ translate('API Key') }}" name="key[0][api_key]"
                                value="{{ $method->keys['api_key'] ?? '' }}" class="form-input">
                        </div>
                    </div>
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Secret Key') }}</label>
                            <input type="text" placeholder="{{ translate('Secret Key') }}"
                                name="key[0][secret_key]" value="{{ $method->keys['secret_key'] ?? '' }}"
                                class="form-input">
                        </div>
                    </div>
                </div>
            @endif
            @endif
            
            @if(isset($method))
            <div class="mt-6">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-full md:col-span-6 mt-3">
                        <div>
                            <label class="form-label"> {{ translate('Conversation your currency to USD') }}
                            </label>
                            <input type="text" placeholder="{{ translate('Conversation rate to USD') }}"
                                name="key[0][conversation_rate]"
                                value="{{ $method->keys['conversation_rate'] ?? '' }}" class="form-input">
                        </div>
                    </div>
                </div>
                <label class="form-label"> {{ translate('Logo') }} <span class="require-field">*</span></label>
                <label for="imgage"
                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer size-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                    <input type="file" hidden name="image" id="imgage"
                        class="dropzone dropzone-image img-src peer/file">
                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                        <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}" alt="file-icon"
                            class="size-8">
                        <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }} </div>
                    </span>
                    <span class="text-danger error-text image_err"></span>
                </label>
                <div class="preview-zone dropzone-preview">
                    <div class="box box-solid">
                        <div class="box-body flex items-center gap-2 flex-wrap">
                            @if (isset($method) && fileExists($folder = 'lms/payments', $fileName = $method->logo) == true && $method->logo != '')
                                <div class="img-thumb-wrapper"> <button class="remove">
                                        <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                    <img class="img-thumb" width="100"
                                        src="{{ asset('storage/lms/payments/' . $method->logo) }}" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="card flex justify-end">
                <button type="submit" class="btn b-solid btn-primary-solid cursor-pointer dk-theme-card-square">
                    {{ isset($method) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </form>
    </div>
</x-dashboard-layout>
