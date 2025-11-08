<x-dashboard-layout>
    <x-slot:title>{{ translate('Backend Manage') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Backend Settings" page-to="Backend" />
    <div class="flex flex-col lg:flex-row gap-x-4">
        <!-- TAB BUTTONS -->
        <div class="lg:w-[320px] shrink-0 card">
            <div class="flex items-center lg:flex-col gap-2 flex-wrap">
                <button
                    class="tablinks btn b-outline btn-primary-outline border-primary-200 justify-start !grow shrink-0 lg:w-full text-sm !text-gray-500 dark:!text-white hover:!text-primary hover:!bg-primary-200 dark:hover:!bg-dark-icon [&.active]:bg-primary-200 dark:[&.active]:bg-dark-icon [&.active]:border-transparent [&.active]:!text-primary dk-theme-card-square ac-transition active"
                    onclick="openStep(event, 'generalSetting')">
                    <i class="ri-settings-line text-inherit"></i>
                    {{ translate('General Setting') }}
                </button>
                <button
                    class="tablinks btn b-outline btn-primary-outline border-primary-200 justify-start !grow shrink-0 lg:w-full text-sm !text-gray-500 dark:!text-white hover:!text-primary hover:!bg-primary-200 dark:hover:!bg-dark-icon [&.active]:bg-primary-200 dark:[&.active]:bg-dark-icon [&.active]:border-transparent [&.active]:!text-primary dk-theme-card-square ac-transition"
                    onclick="openStep(event, 'logo')">
                    <i class="ri-dv-line text-inherit"></i>
                    {{ translate('Logo') }}
                </button>
                <button
                    class="tablinks btn b-outline btn-primary-outline border-primary-200 justify-start !grow shrink-0 lg:w-full text-sm !text-gray-500 dark:!text-white hover:!text-primary hover:!bg-primary-200 dark:hover:!bg-dark-icon [&.active]:bg-primary-200 dark:[&.active]:bg-dark-icon [&.active]:border-transparent [&.active]:!text-primary dk-theme-card-square ac-transition"
                    onclick="openStep(event, 'smtp-setting')">
                    <i class="ri-mail-settings-line text-inherit"></i>
                    {{ translate('SMTP Setting') }}
                </button>

                <button
                    class="tablinks btn b-outline btn-primary-outline border-primary-200 justify-start !grow shrink-0 lg:w-full text-sm !text-gray-500 dark:!text-white hover:!text-primary hover:!bg-primary-200 dark:hover:!bg-dark-icon [&.active]:bg-primary-200 dark:[&.active]:bg-dark-icon [&.active]:border-transparent [&.active]:!text-primary dk-theme-card-square ac-transition"
                    onclick="openStep(event, 'openai-setting')">
                    <i class="ri-sparkling-2-line text-inherit"></i>
                    {{ translate('Ai Setting') }}
                </button>

                <button
                    class="tablinks btn b-outline btn-primary-outline border-primary-200 justify-start !grow shrink-0 lg:w-full text-sm !text-gray-500 dark:!text-white hover:!text-primary hover:!bg-primary-200 dark:hover:!bg-dark-icon [&.active]:bg-primary-200 dark:[&.active]:bg-dark-icon [&.active]:border-transparent [&.active]:!text-primary dk-theme-card-square ac-transition"
                    onclick="openStep(event, 'system-information')">
                    <i class="ri-information-2-line text-inherit"></i>
                    {{ translate('System Information') }}
                </button>
            </div>
        </div>

        <!-- TAB CONTENTS -->
        <div class="grow">
            <!-- START GENERAL SETTINGS CONTENTS -->
            <div id="generalSetting" class="tabcontent card block">

                <div class="mb-10">
                    <a href="{{ route('cache.clear') }}" class="btn b-solid btn-warning-solid"
                        title="{{ translate('Be careful, it may affect performance') }}.">
                        {{ translate('Clear Cache') }}</a>
                    <a href="{{ route('cache.optimize') }}" class="btn b-solid btn-primary-solid"
                        title="{{ translate('Best for production performance') }}.">{{ translate('Optimize Cache') }}</a>
                    <a href="{{ route('storage.link') }}"
                        class="btn b-solid btn-secondary-solid">{{ translate('Storage Link') }}</a>
                </div>
                @php
                    $backendSetting = get_theme_option(key: 'backend_general') ?? [];
                    $currency = $backendSetting['currency'] ?? 'USD-$';
                    $currencySymbol = get_currency_symbol($currency);
                @endphp
                <form enctype="multipart/form-data" class="add_setting" method="POST"
                    action="{{ route('theme.setting') }}" data-key="backend_general">
                    @csrf
                    <h6 class="leading-none text-xl font-semibold text-heading"> {{ translate('General Setting') }}
                    </h6>
                    <div class="mt-7">
                        <div class="leading-none">
                            <label for="currency" class="form-label">{{ translate('Currency') }}</label>
                            <select data-select id="currency" name="currency" class="singleSelect">
                                <option selected disabled> {{ translate('Select Currency') }} </option>
                                @foreach (all_currency() as $currency)
                                    @php
                                        $codeSymbol = $currency->code . '-' . $currency->symbol;
                                    @endphp
                                    <option value="{{ $currency->code . '-' . $currency->symbol }}"
                                        {{ isset($backendSetting['currency']) && $backendSetting['currency'] == $codeSymbol ? 'selected' : '' }}>
                                        {{ $currency->symbol }} - {{ $currency->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="leading-none mt-6">
                            <label class="form-label"> {{ translate('Platform free') }}
                                ({{ $currencySymbol }})</label>
                            <input type="number" name="platform_fee"
                                placeholder="{{ translate('Enter Platform Free') }}" class="form-input" step="0.01"
                                value="{{ $backendSetting['platform_fee'] ?? '' }}">
                        </div>

                        <div class="leading-none mt-6">
                            <label class="form-label"> {{ translate('Application Name') }} </label>
                            <input type="text" name="app_name"
                                placeholder="{{ translate('Enter Your Application Name') }}" class="form-input"
                                value="{{ $backendSetting['app_name'] ?? '' }}">
                        </div>
                        <div class="leading-none mt-6">
                            <label class="form-label"> {{ translate('Contact Email') }} </label>
                            <input type="text" name="contact_email"
                                placeholder="{{ translate('Enter Your Contact Email') }}" class="form-input"
                                value="{{ $backendSetting['contact_email'] ?? '' }}">
                        </div>
                        <div class="leading-none mt-6">
                            <label class="form-label"> {{ translate('Contact Email') }} </label>
                            <input type="text" name="contact_email"
                                placeholder="{{ translate('Enter Your Contact Email') }}" class="form-input"
                                value="{{ $backendSetting['contact_email'] ?? '' }}">
                        </div>
                        <div class="leading-none mt-6">
                            <label class="form-label"> {{ translate('Time Zone') }} </label>
                            <select class="singleSelect form-input" id="time_zone" name="time_zone">
                                <option selected disabled>{{ translate('Select Time Zone') }}</option>
                                @foreach (getTimezone() as $key => $getTimezone)
                                    <option value="{{ $getTimezone['value'] }}"
                                        {{ isset($backendSetting, $backendSetting['time_zone']) && $backendSetting['time_zone'] == $getTimezone['value'] ? 'selected' : '' }}>
                                        {{ $getTimezone['label'] }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        @php
                            $backendGeneral = get_theme_option(key: 'backend_general') ?? null;
                        @endphp
                        <div class="leading-none mt-6">
                            <label class="form-label"> {{ translate('Date Format') }} </label>
                            <select class="form-input singleSelect" name="date_format" id="date_format"
                                required="required">
                                <option selected disabled>{{ 'Select date format' }} </option>
                                <option value="M j, Y"
                                    {{ old('date_format', $backendGeneral['date_format'] ?? null) == 'M j, Y' ? 'selected' : '' }}>
                                    Oct 30, 2023</option>
                                <option value="Y-m-d"
                                    {{ old('date_format', $backendGeneral['date_format'] ?? null) == 'Y-m-d' ? 'selected' : '' }}>
                                    2023-10-30</option>
                                <option value="d-m-Y"
                                    {{ old('date_format', $backendGeneral['date_format'] ?? null) == 'd-m-Y' ? 'selected' : '' }}>
                                    30-10-2023</option>
                                <option value="d/m/Y"
                                    {{ old('date_format', $backendGeneral['date_format'] ?? null) == 'd/m/Y' ? 'selected' : '' }}>
                                    30/10/2023 </option>
                                <option value="m/d/Y"
                                    {{ old('date_format', $backendGeneral['date_format'] ?? null) == 'm/d/Y' ? 'selected' : '' }}>
                                    10/30/2023 </option>
                                <option value="m.d.Y"
                                    {{ old('date_format', $backendGeneral['date_format'] ?? null) == 'm.d.Y' ? 'selected' : '' }}>
                                    10.30.2023 </option>
                                <option value="j, n, Y"
                                    {{ old('date_format', $backendGeneral['date_format'] ?? null) == 'j, n, Y' ? 'selected' : '' }}>
                                    30, 10, 2023 </option>
                                <option value="F j, Y"
                                    {{ old('date_format', $backendGeneral['date_format'] ?? null) == 'F j, Y' ? 'selected' : '' }}>
                                    October 30, 2023 </option>
                                <option value="M j, Y"
                                    {{ old('date_format', $backendGeneral['date_format'] ?? null) == 'M j, Y' ? 'selected' : '' }}>
                                    Oct 30, 2023</option>
                                <option value="j M, Y"
                                    {{ old('date_format', $backendGeneral['date_format'] ?? null) == 'j M, Y' ? 'selected' : '' }}>
                                    30 Oct, 2023</option>
                            </select>
                        </div>
                    </div>




                    <div class="flex justify-end mt-10">
                        <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </form>
            </div>
            <!-- START LOGO CONTENTS -->
            <div id="logo" class="tabcontent card hidden">

                @php
                    $backendLogo = get_theme_option(key: 'backend_logo') ?? null;
                @endphp
                <form enctype="multipart/form-data" class="add_setting" method="POST"
                    action="{{ route('theme.setting') }}" data-key="backend_logo">
                    @csrf
                    <div class="grid grid-cols-3 gap-x-4 gap-y-6 mt-7">
                        <div class="col-span-full xl:col-auto leading-none">
                            <label class="form-label">
                                {{ translate('Logo') }}({{ translate('100') }}x{{ translate('35') }})</label>
                            <label for="imgage"
                                class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                <input type="file" class="dropzone theme-setting-image" hidden id ="imgage">
                                <input type="hidden" name="logo" id="oldFile"
                                    value="{{ $backendLogo['logo'] ?? null }}">
                                <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                    <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}" alt="file-icon"
                                        class="size-8 lg:size-auto">
                                    <div class="text-gray-500 dark:text-dark-text mt-2">{{ translate('Choose file') }}
                                    </div>
                                </span>
                            </label>
                            <div class="preview-zone dropzone-preview">
                                <div class="box box-solid">
                                    <div class="box-body flex items-center gap-2 flex-wrap">
                                        @if (isset(get_theme_option(key: 'backend_logo')['logo']))
                                            @if (fileExists($folder = 'lms/theme-options', $fileName = $backendLogo['logo']) == true && $backendLogo['logo'] !== '')
                                                <div class="img-thumb-wrapper">
                                                    <button class="remove"> <i
                                                            class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" class="img-thumb !size-auto"
                                                        src="{{ asset('storage/lms/theme-options/' . $backendLogo['logo']) }}" />
                                                </div>
                                            @else
                                                <div class="img-thumb-wrapper max-w-[120px] max-h-[120px]">
                                                    <button class="remove text-danger">
                                                        <i class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" width="auto" height="auto">
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label class="form-label">
                                {{ translate('Favicon') }}({{ translate('16') }}x{{ translate('16') }})</label>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="imgageFav"
                                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                    <input type="file" class="dropzone theme-setting-image" hidden id="imgageFav">
                                    <input type="hidden" name="favicon" id="oldFile"
                                        value="{{ $backendLogo['favicon'] ?? null }}">
                                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                        <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                                            alt="file-icon" class="size-8 lg:size-auto">
                                        <div class="text-gray-500 dark:text-dark-text mt-2">
                                            {{ translate('Choose file') }}
                                        </div>
                                    </span>
                                </label>
                                <div class="preview-zone dropzone-preview">
                                    <div class="box box-solid">
                                        <div class="box-body flex items-center gap-2 flex-wrap">

                                            @if (isset($backendLogo['favicon']) &&
                                                    fileExists($folder = 'lms/theme-options', $fileName = $backendLogo['favicon']) == true &&
                                                    $backendLogo['favicon'] !== '')
                                                <div class="img-thumb-wrapper"> <button class="remove text-danger">
                                                        <i class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" width="50" height="50"
                                                        src="{{ asset('storage/lms/theme-options/' . $backendLogo['favicon']) }}" />
                                                </div>
                                            @else
                                                <div class="img-thumb-wrapper max-w-[120px] max-h-[120px]">
                                                    <button class="remove text-danger">
                                                        <i class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" width="auto" height="auto">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-span-full xl:col-auto leading-none">
                            <label
                                class="form-label">{{ translate('Icon Logo') }}({{ translate('40') }}x{{ translate('40') }})</label>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="icon_logo"
                                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                    <input type="file" class="dropzone theme-setting-image" hidden id="icon_logo">
                                    <input type="hidden" name="icon_logo" id="oldFile"
                                        value="{{ $backendLogo['icon_logo'] ?? null }}">
                                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                        <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                                            alt="file-icon" class="size-8 lg:size-auto">
                                        <div class="text-gray-500 dark:text-dark-text mt-2">
                                            {{ translate('Choose file') }}
                                        </div>
                                    </span>
                                </label>
                                <div class="preview-zone dropzone-preview">
                                    <div class="box box-solid">
                                        <div class="box-body flex items-center gap-2 flex-wrap">
                                            @if (isset($backendLogo['icon_logo']) &&
                                                    fileExists($folder = 'lms/theme-options', $fileName = $backendLogo['icon_logo']) == true &&
                                                    $backendLogo['icon_logo'] !== '')
                                                <div class="img-thumb-wrapper"> <button class="remove text-danger">
                                                        <i class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" width="100" height="100"
                                                        src="{{ asset('storage/lms/theme-options/' . $backendLogo['icon_logo']) }}" />
                                                </div>
                                            @else
                                                <div class="img-thumb-wrapper max-w-[120px] max-h-[120px]">
                                                    <button class="remove text-danger">
                                                        <i class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" width="auto" height="auto">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-span-full xl:col-auto leading-none">
                            <label
                                class="form-label">{{ translate('Dark Mood Logo') }}({{ translate('100') }}x{{ translate('35') }})</label>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="dark_logo"
                                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                    <input type="file" class="dropzone theme-setting-image" hidden id="dark_logo">
                                    <input type="hidden" name="dark_logo" id="oldFile"
                                        value="{{ $backendLogo['dark_logo'] ?? null }}">
                                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                        <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                                            alt="file-icon" class="size-8 lg:size-auto">
                                        <div class="text-gray-500 dark:text-dark-text mt-2">
                                            {{ translate('Choose file') }}
                                        </div>
                                    </span>
                                </label>
                                <div class="preview-zone dropzone-preview">
                                    <div class="box box-solid">
                                        <div class="box-body flex items-center gap-2 flex-wrap">
                                            @if (isset($backendLogo['dark_logo']) &&
                                                    fileExists($folder = 'lms/theme-options', $fileName = $backendLogo['dark_logo']) == true &&
                                                    $backendLogo['dark_logo'] !== '')
                                                <div class="img-thumb-wrapper"> <button class="remove text-danger">
                                                        <i class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" width="100" height="100"
                                                        src="{{ asset('storage/lms/theme-options/' . $backendLogo['dark_logo']) }}" />
                                                </div>
                                            @else
                                                <div class="img-thumb-wrapper max-w-[120px] max-h-[120px]">
                                                    <button class="remove text-danger">
                                                        <i class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" width="auto" height="auto">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-span-full xl:col-auto leading-none">
                            <label
                                class="form-label">{{ translate('Dark Icon Logo') }}({{ translate('40') }}x{{ translate('40') }})</label>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="dark_icon_logo"
                                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                    <input type="file" class="dropzone theme-setting-image" hidden
                                        id="dark_icon_logo">
                                    <input type="hidden" name="dark_icon_logo" id="oldFile"
                                        value="{{ $backendLogo['dark_icon_logo'] ?? null }}">
                                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                        <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                                            alt="file-icon" class="size-8 lg:size-auto">
                                        <div class="text-gray-500 dark:text-dark-text mt-2">
                                            {{ translate('Choose file') }}
                                        </div>
                                    </span>
                                </label>
                                <div class="preview-zone dropzone-preview">
                                    <div class="box box-solid">
                                        <div class="box-body flex items-center gap-2 flex-wrap">
                                            @if (isset($backendLogo['dark_icon_logo']) &&
                                                    fileExists($folder = 'lms/theme-options', $fileName = $backendLogo['dark_icon_logo']) == true &&
                                                    $backendLogo['dark_icon_logo'] !== '')
                                                <div class="img-thumb-wrapper"> <button class="remove text-danger">
                                                        <i class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" width="100" height="100"
                                                        src="{{ asset('storage/lms/theme-options/' . $backendLogo['dark_icon_logo']) }}" />
                                                </div>
                                            @else
                                                <div class="img-thumb-wrapper max-w-[120px] max-h-[120px]">
                                                    <button class="remove text-danger">
                                                        <i class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" width="auto" height="auto">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-span-full xl:col-auto leading-none">
                            <label class="form-label">{{ translate('Invoice Logo') }}</label>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="invoice_logo"
                                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                    <input type="file" class="dropzone theme-setting-image" hidden
                                        id="invoice_logo">
                                    <input type="hidden" name="invoice_logo" id="oldFile"
                                        value="{{ $backendLogo['invoice_logo'] ?? null }}">
                                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                        <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                                            alt="file-icon" class="size-8 lg:size-auto">
                                        <div class="text-gray-500 dark:text-dark-text mt-2">
                                            {{ translate('Choose file') }}
                                        </div>
                                    </span>
                                </label>
                                <div class="preview-zone dropzone-preview">
                                    <div class="box box-solid">
                                        <div class="box-body flex items-center gap-2 flex-wrap">
                                            @if (isset($backendLogo['invoice_logo']) &&
                                                    fileExists($folder = 'lms/theme-options', $fileName = $backendLogo['invoice_logo']) == true &&
                                                    $backendLogo['invoice_logo'] !== '')
                                                <div class="img-thumb-wrapper"> <button class="remove text-danger">
                                                        <i class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" width="100" height="100"
                                                        src="{{ asset('storage/lms/theme-options/' . $backendLogo['invoice_logo']) }}" />
                                                </div>
                                            @else
                                                <div class="img-thumb-wrapper max-w-[120px] max-h-[120px]">
                                                    <button class="remove text-danger">
                                                        <i class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" width="auto" height="auto">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="flex justify-end mt-10">
                        <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </form>
            </div>
            <!-- START SMPT SETTINGS CONTENTS -->
            <div id="smtp-setting" class="tabcontent card hidden">
                <h6 class="leading-none text-xl font-semibold text-heading">
                    {{ translate('SMPT Settings') }}
                </h6>
                <form enctype="multipart/form-data" class="add_setting" method="POST"
                    action="{{ route('theme.setting') }}" data-key="mail_setting">
                    @csrf

                    @php
                        $mail = get_theme_option(key: 'mail_setting');
                    @endphp
                    <div class="grid grid-cols-2 gap-x-4 gap-y-6 mt-7">
                        <div class="col-span-full xl:col-auto leading-none">
                            <label class="form-label">{{ translate('Driver') }}</label>
                            <select name="mail_driver" class="form-input dark:bg-dark-card-two">
                                <option>{{ translate('Select Option') }}</option>
                                <option value="smtp"
                                    {{ isset($mail['mail_driver']) && $mail['mail_driver'] == 'smtp' ? 'selected' : '' }}>
                                    {{ translate('smtp') }}</option>
                                <option
                                    value="sendmail"{{ isset($mail['mail_driver']) && $mail['mail_driver'] == 'sendmail' ? 'selected' : '' }}>
                                    {{ translate('sendmail') }}</option>
                            </select>
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label class="form-label"> {{ translate('Mail Host') }} </label>
                            <input type="text" id="meta_title" class="form-input"
                                value="{{ $mail['mail_host'] ?? '' }}" name="mail_host"
                                placeholder="{{ translate('Host') }}">
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label class="form-label"> {{ translate('Mail Port') }} </label>
                            <input type="text" class="form-input" name="mail_port"
                                value="{{ $mail['mail_port'] ?? '' }}" placeholder="{{ translate('Port') }}" />
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label class="form-label"> {{ translate('From Address') }} </label>
                            <input type="text" class="form-input" value="{{ $mail['mail_from_address'] ?? '' }}"
                                name="mail_from_address" placeholder="{{ translate('From Address') }}" />
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label class="form-label"> {{ translate('Mail User Name') }} </label>
                            <input type="text" class="form-input" value="{{ $mail['mail_username'] ?? '' }}"
                                name="mail_username" placeholder="{{ translate('User Name') }}" />
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label class="form-label"> {{ translate('Mail Encryption') }} </label>
                            <select name="mail_encryption" class="form-input dark:bg-dark-card-two">
                                <option>{{ translate('Select Option') }}</option>
                                <option value="tls"
                                    {{ isset($mail['mail_encryption']) && $mail['mail_encryption'] == 'tls' ? 'selected' : '' }}>
                                    {{ translate('TLS') }}</option>
                                <option
                                    value="ssl"{{ isset($mail['mail_encryption']) && $mail['mail_encryption'] == 'SSL' ? 'selected' : '' }}>
                                    {{ translate('SSL') }}</option>
                            </select>
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <label class="form-label">{{ translate('Password') }} </label>
                            <input type="text" class="form-input" value="{{ $mail['password'] ?? null }}"
                                name="password" placeholder="{{ translate('Password') }}" />
                        </div>
                    </div>
                    <div class="flex justify-end mt-10">
                        <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </form>
            </div>

            <div id="openai-setting" class="tabcontent hidden">
                <div class="card">
                    <h6 class="leading-none text-xl font-semibold text-heading">
                        {{ translate('ChatGPT setting') }}
                    </h6>
                    <form enctype="multipart/form-data" class="add_setting" method="POST"
                        action="{{ route('theme.setting') }}" data-key="ai_setting">
                        @csrf
                        @php
                            $openAi = get_theme_option(key: 'ai_setting') ?? [];
                        @endphp
                        <div class="grid grid-cols-2 gap-x-4 gap-y-6 mt-7">
                            <div class="col-span-full xl:col-auto leading-none">
                                <label class="form-label">{{ translate('Select ChatGPT Model') }}</label>
                                <select name="ai_modal" class="form-input dark:bg-dark-card-two singleSelect">
                                    <option>{{ translate('Select model') }}</option>
                                    <option value="gpt-4o"
                                        {{ isset($openAi['ai_modal']) && $openAi['ai_modal'] == 'gpt-4o' ? 'selected' : '' }}>
                                        gpt-4o
                                    </option>
                                    <option value="gpt-4o-mini"
                                        {{ isset($openAi['ai_modal']) && $openAi['ai_modal'] == 'gpt-4o-mini' ? 'selected' : '' }}>
                                        gpt-4o-mini </option>
                                    <option value="gpt-3.5-turbo-0125"
                                        {{ isset($openAi['ai_modal']) && $openAi['ai_modal'] == 'gpt-3.5-turbo-0125' ? 'selected' : '' }}>
                                        gpt-3.5-turbo-0125
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label class="form-label"> {{ translate('ChatGPT Secret Key') }} </label>
                                <input type="text" class="form-input" value="{{ $openAi['secret_key'] ?? '' }}"
                                    name="secret_key" placeholder="{{ translate('Secret Key') }}">
                            </div>
                        </div>
                        <div class="flex justify-end mt-10">
                            <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                                {{ translate('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- START SYSTEM INFORMATION CONTENTS -->
            <div id="system-information" class="tabcontent card hidden">
                <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('System Information') }}
                </h6>
                <div class="overflow-x-auto mt-7">
                    <table
                        class="table-auto border-collapse dk-border-one w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text text-sm leading-none">
                        <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                            <tr>
                                <td class="px-3 py-3 dk-border-one text-heading dark:text-white font-semibold w-10">
                                    {{ translate('PHP Version') }}</td>
                                <td class="px-5 py-3 dk-border-one">{{ phpversion() }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-3 dk-border-one text-heading dark:text-white font-semibold w-10">
                                    {{ translate('Laravel Version') }}</td>
                                <td class="px-5 py-3 dk-border-one">{{ app()->version() }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-3 dk-border-one text-heading dark:text-white font-semibold w-10">
                                    {{ translate('Server  Software') }}</td>
                                <td class="px-5 py-3 dk-border-one">{{ translate('LiteSpeed') }}</td>
                            </tr>
                            <tr>

                                <td class="px-3 py-3 dk-border-one text-heading dark:text-white font-semibold w-10">
                                    {{ translate('Server IP Address') }}</td>
                                <td class="px-5 py-3 dk-border-one">{{ $_SERVER['REMOTE_ADDR'] }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-3 dk-border-one text-heading dark:text-white font-semibold w-10">
                                    {{ translate('Server Protocol') }}</td>
                                <td class="px-5 py-3 dk-border-one">{{ $_SERVER['SERVER_PROTOCOL'] }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-3 dk-border-one text-heading dark:text-white font-semibold w-10">
                                    {{ translate('HTTP Host') }}
                                </td>
                                <td class="px-5 py-3 dk-border-one">{{ env('DB_HOST') }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-3 dk-border-one text-heading dark:text-white font-semibold w-10">
                                    {{ translate('Database Port') }}</td>
                                <td class="px-5 py-3 dk-border-one">{{ env('DB_PORT') }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-3 dk-border-one text-heading dark:text-white font-semibold w-10">
                                    {{ translate('App Environment') }}</strong></td>
                                <td class="px-5 py-3 dk-border-one">{{ Config::get('app.env') }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-3 dk-border-one text-heading dark:text-white font-semibold w-10">
                                    {{ translate('App Debug') }}
                                </td>
                                <td class="px-5 py-3 dk-border-one">
                                    {{ Config::get('app.debug') == 1 ? translate('True') : translate('False') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-3 dk-border-one text-heading dark:text-white font-semibold w-10">
                                    {{ translate('Timezone') }}
                                </td>
                                <td class="px-5 py-3 dk-border-one">{{ Config::get('app.timezone') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
