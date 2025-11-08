<x-dashboard-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('lms/assets/css/vendor/codemirror/codemirror.css') }}">
        <link rel="stylesheet" href="{{ asset('lms/assets/css/vendor/codemirror/theme/material-darker.css') }}">
        <link rel="stylesheet" href="{{ asset('lms/assets/css/vendor/codemirror/theme/material.css') }}">

        <script src="{{ asset('lms/assets/js/vendor/codemirror/codemirror.js') }}"></script>
        <script src="{{ asset('lms/assets/js/vendor/codemirror/javascript/javascript.js') }}"></script>
        <script src="{{ asset('lms/assets/js/vendor/codemirror/addon/hint/css-hint.js') }}"></script>
        <script src="{{ asset('lms/assets/js/vendor/codemirror/addon/hint/anyword-hint.js') }}"></script>
        <script src="{{ asset('lms/assets/js/vendor/codemirror/addon/comment/continuecomment.js') }}"></script>
        <script src="{{ asset('lms/assets/js/vendor/codemirror/addon/edit/matchbrackets.js') }}"></script>
        <script src="{{ asset('lms/assets/js/vendor/codemirror/addon/selection/active-line.js') }}"></script>
    @endpush
    <x-slot:title> {{ translate('Themesetting/manage') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Theme Settings" page-to="Theme" />

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
                    onclick="openStep(event, 'cookie')">
                    <i class="ri-server-line text-inherit"></i>
                    {{ translate('GDPR Cookie') }}
                </button>
                <button
                    class="tablinks btn b-outline btn-primary-outline border-primary-200 justify-start !grow shrink-0 lg:w-full text-sm !text-gray-500 dark:!text-white hover:!text-primary hover:!bg-primary-200 dark:hover:!bg-dark-icon [&.active]:bg-primary-200 dark:[&.active]:bg-dark-icon [&.active]:border-transparent [&.active]:!text-primary dk-theme-card-square ac-transition"
                    onclick="openStep(event, 'tawk-chat')">
                    <i class="ri-kakao-talk-line text-inherit"></i>
                    {{ translate('Tawk Chat') }}
                </button>

                <button
                    class="tablinks btn b-outline btn-primary-outline border-primary-200 justify-start !grow shrink-0 lg:w-full text-sm !text-gray-500 dark:!text-white hover:!text-primary hover:!bg-primary-200 dark:hover:!bg-dark-icon [&.active]:bg-primary-200 dark:[&.active]:bg-dark-icon [&.active]:border-transparent [&.active]:!text-primary dk-theme-card-square ac-transition"
                    onclick="openStep(event, 'mailchimp')">
                    <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                        viewBox="0 0 46.649 46.649" xml:space="preserve">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <g>
                                    <path
                                        d="M5.961,22.944c0.973,0.525,1.003,1.269,0.39,2.188c-1.022,1.53-0.945,3.566,0.006,5.714 c0.804,1.816,2.968,2.688,4.763,3.062c0.958,0.2,0.661,0.674,1.184,2.277c3.529,10.83,13.622,12.766,23.354,8.043 c0.746-0.362,1.471-0.763,2.166-1.199c0.936-0.588,1.792-1.211,1.957-1.333c0.166-0.122,0.94-0.848,1.676-1.671 c1.849-2.068,3.015-4.642,2.949-7.792c-0.009-0.438-0.049-0.856-0.11-1.26c-0.104-0.689-0.231-1.735-0.294-2.347 c-0.036-0.355-0.095-0.721-0.182-1.096c-0.027-0.116-0.115-0.183-0.241-0.212c-0.182-0.044-0.69-0.84-1.121-1.858 c-0.666-1.578-1.237-3.158-1.205-5.025c0.029-1.623,0.137-4.743-0.923-6.587c-0.55-0.957-0.732-1.872-0.186-2.831 C41.55,8.55,41.287,5,40.371,2.527c-1.237-3.345-6.424-2.669-8.968-1.891c-0.94,0.288-1.874,0.649-2.798,1.069 c-1.005,0.456-2.464,0.283-3.437-0.242C19.193-1.76,12.175,3.414,7.611,7.954C2.41,13.128-0.522,19.44,5.961,22.944z M34.645,43.553c-2.786,1.578-6.031,2.378-9.104,2.07c-1.099-0.11-1.804-0.526-1.604-0.733c0.199-0.207-0.087-0.555-0.612-0.837 c-0.523-0.281-1.136-0.343-1.397-0.079c-0.263,0.265-0.765,0.333-1.105,0.125c-0.342-0.207-0.365-0.637-0.067-0.938 c0.299-0.301,0.529-0.553,0.519-0.565c-0.012-0.011-0.258,0.229-0.551,0.536c-0.293,0.308-0.663,0.467-0.825,0.355 c-0.097-0.067-0.193-0.138-0.287-0.211c-0.159-0.126-0.312-0.261-0.462-0.4c-0.247-0.23-0.165-0.721,0.172-1.081 c0.336-0.36,0.26-1.099-0.115-1.692c-0.375-0.593-0.957-0.778-1.353-0.385c-0.396,0.395-1.21-0.038-1.699-1.027 c-0.051-0.104-0.102-0.207-0.151-0.312c-0.472-0.998-0.4-2.215,0.056-2.672s0.774-0.989,0.714-1.188 c-0.062-0.198-0.208-0.395-0.332-0.44s-0.539,0.204-0.928,0.561c-0.389,0.357-0.857,0.16-1.023-0.449 c-0.103-0.378-0.196-0.748-0.277-1.11c-0.04-0.181-0.332-0.237-0.474-0.244c-0.798-0.035-1.672-0.38-2.499-0.92 c-0.924-0.604-1.233-1.553-0.867-1.889s0.425-0.931,0.19-1.36s-0.715-0.485-1.141-0.09c-0.425,0.395-1.011,0.35-1.229-0.141 c-0.219-0.489,0.181-1.379,0.79-1.947c0.608-0.569,1.303-1.619,1.851-2.103c0.547-0.482,1.143-0.692,1.16-0.709 c0.019-0.017,0.437,0.051,0.91-0.064c0.304-0.074,0.581-0.214,0.757-0.428c2.235-2.712,5.628-6.171,9.34-8.102 c0.98-0.51,1.273-0.296,0.59,0.338c-0.684,0.634-0.521,0.607,0.423,0.033c0.686-0.417,1.388-0.787,2.098-1.096 c1.013-0.441,1.904-0.681,1.929-0.704c0.025-0.023,0.953-0.099,2.032,0.139c0.204,0.045,0.407,0.098,0.609,0.161 c1.056,0.325,1.611,0.986,1.365,1.199c-0.245,0.213-0.522,0.37-0.631,0.345c-0.107-0.024-0.069-0.165,0.085-0.313 c0.155-0.148,0.225-0.273,0.152-0.276s-0.184,0.015-0.25,0.043c-0.038,0.016-0.099,0.057-0.165,0.108 c-0.085,0.067-0.122,0.097-0.095,0.055c0.029-0.047,0.033-0.069-0.007-0.051c-0.058,0.026-0.159,0.1-0.228,0.165 c-0.067,0.066-1.003-0.081-2.106-0.1c-1.7-0.028-3.406,0.351-4.777,1.211c-2.457,1.542-3.928,2.765-3.86,5.779 c0.028,1.269,2.494,3.775,2.138,4.29c-6.055,8.741,3.688,15.436,12.022,16.036C35.426,42.524,35.605,43.009,34.645,43.553z M40.973,36.852c-0.47,1.062-1.096,2.06-1.844,2.974c-0.699,0.854-2.257,1.618-3.36,1.59c-0.187-0.004-0.373-0.014-0.561-0.027 c-1.102-0.079-1.921-0.354-1.852-0.424s0.006-0.188-0.139-0.268s-0.343-0.062-0.443,0.043c-0.103,0.104-0.995-0.023-1.948-0.417 c-0.953-0.395-1.463-1.038-1.198-1.311c0.266-0.272,0.112-0.741-0.314-1.083c-0.427-0.34-0.998-0.396-1.302-0.089 c-0.305,0.307-0.805,0.364-1.104,0.112s-0.262-0.741,0.069-1.074s0.562-0.646,0.521-0.698c-0.042-0.053-0.343,0.186-0.672,0.532 s-0.926,0.318-1.295-0.099s-0.33-1.108,0.045-1.509c0.375-0.401,0.488-1.073,0.311-1.527c-0.179-0.454,0.064,0.004,0.758,0.865 c3.066,3.808,9.255,4.097,13.368,1.699C40.966,35.586,41.42,35.842,40.973,36.852z M38.797,35.555l0.23-0.225 c0.253-0.254,0.505-0.508,0.758-0.763c0.418-0.421,0.452-0.198-0.099,0.354C39.135,35.475,38.67,35.68,38.797,35.555z M41.442,30.517c-0.032,0.867-0.836,2.193-1.607,2.984c-0.255,0.261-0.51,0.522-0.764,0.784c-0.771,0.79-1.298,1.5-1.174,1.582 c0.124,0.083-0.174,0.34-0.7,0.486c-0.306,0.085-0.629,0.149-0.97,0.19c-0.63,0.077-1.262,0.065-1.882-0.023 c-1.032-0.148-1.61-0.706-1.353-0.973c0.258-0.265,0.183-0.819-0.103-1.286c-0.285-0.465-0.823-0.511-1.266-0.064 c-0.441,0.444-0.784,0.838-0.763,0.875c0.022,0.037-0.724-0.425-1.461-1.249c-0.021-0.025-0.043-0.049-0.065-0.073 c-0.726-0.833-0.356-1.715,0.56-1.817c0.916-0.101,1.341,0.121,0.954,0.53c-0.388,0.409-0.682,0.824-0.651,0.924 c0.03,0.102,0.484-0.252,1.015-0.788c0.53-0.534,1.512-1.053,2.188-1.18c0.676-0.126,1.095-0.117,0.939,0.041 c-0.156,0.157,0.348,0.263,1.125,0.211c0.776-0.051,1.733-0.446,2.139-0.86c0.404-0.413,1.418-0.977,2.252-1.28 C40.691,29.229,41.475,29.65,41.442,30.517z M40.229,26.205c0.514,0.978,0.71,1.873,0.542,1.951 c-0.149,0.068-0.27,0.124-0.307,0.14c-1.698,0.703-3.444,1.29-5.185,1.878c-2.66,0.619-5.397,0.892-8.122,0.987 c-0.271,0.009-2.043,0.353-1.862,0.877c0.009,0.024,0.02,0.046,0.029,0.068c0.019,0.036-0.333,0.431-0.778,0.88 c-0.444,0.448-1.182-0.018-1.333-1.111c-0.092-0.665-0.094-1.345,0.009-2.035c0.161-1.093,1.176-2.557,1.948-3.346 c0.103-0.104,0.203-0.207,0.305-0.311c0.771-0.79,1.348-1.487,1.285-1.561c-0.062-0.072-0.539,0.256-1.069,0.736 s-0.892,0.772-0.809,0.653c0.049-0.07,0.1-0.142,0.154-0.212c0.109-0.141,0.172-0.269,0.03-0.412 c-0.365-0.366-0.67-0.788-0.916-1.243c-0.406-0.755-0.129-1.849,0.399-2.35c0.527-0.501,0.955-0.996,0.961-1.106 c0.006-0.109-0.435,0.237-0.984,0.774c-0.549,0.537-1.214,0.084-1.118-1.016c0.225-2.586,1.972-4.824,5.214-4.134 c1.08,0.23,2.055,0.894,2.374,0.912c0.21,0.012,0.436-0.023,0.579-0.039c0.163-0.018,0.323-0.051,0.479-0.099 c0.043-0.014,0.381-0.149,0.688-0.32c0.367-0.204,0.728-0.593,0.934-0.77c0.206-0.176,0.979-0.989,1.92-1.57 c0.896-0.554,1.738-0.666,2.366,0.762c0.776,1.766,0.678,4.057,0.689,5.94C38.667,23.458,39.416,24.659,40.229,26.205z M25.632,5.166c0.596-0.42,1.397-0.834,1.742-1.025c0.346-0.191,1.111-0.911,1.923-1.387c0.491-0.288,0.987-0.565,1.49-0.83 c0.074-0.039,0.146-0.074,0.218-0.108c0.122-0.058,0.243-0.095,0.271-0.085c0.027,0.009,0.083-0.015,0.124-0.057 c0.042-0.042,0.9-0.484,1.999-0.593c4.901-0.485,6.603,6.336,4.733,9.917c-0.512,0.979-1.812,1.615-2.424,1.855 c-0.611,0.24-1.826-0.001-2.851-0.416c-0.27-0.109-0.539-0.205-0.81-0.29c-1.055-0.329-1.881-0.478-1.787-0.564 c0.064-0.06-0.082-0.103-0.351-0.099c-0.23,0.004-1.072,0.104-1.877,0.202c-0.472,0.057-0.982,0.128-1.453,0.218 c-5.884,1.135-11.578,6.278-15.095,10.544c-0.179,0.216-0.254,0.406-0.252,0.567c0.003,0.349-0.286,1.123-1.067,1.905 c-0.301,0.302-0.61,0.612-0.929,0.93c-0.781,0.782-1.669,0.438-1.121-0.521c0.34-0.593,0.948-1.098,1.896-1.448 c0.021-0.008,0.036-0.015,0.056-0.023c0.039-0.015,0.074-0.03,0.112-0.046c0.137-0.058,0.247-0.114,0.333-0.169 c0.174-0.11,0.264-0.289,0.282-0.313c0.013-0.015,0.023-0.03,0.029-0.047c1.392-3.505,3.328-6.64,5.645-9.481 c1.931-1.982,3.833-3.931,5.708-5.852c0.779-0.682,1.574-1.35,2.393-1.997C24.916,5.679,25.271,5.419,25.632,5.166z M4.366,15.616 c0.111-0.894,0.531-1.806,1.111-2.7c0.602-0.926,0.871-1.135,0.505-0.538c-0.366,0.597,0.013,0.468,0.785-0.321 c2.806-2.866,5.186-5.282,6.952-7.05c0.779-0.782,1.481-1.448,1.562-1.49c0.081-0.042-0.476,0.567-1.244,1.361 c-2.399,2.479-5.555,5.728-7.575,7.813c-0.769,0.794-1.395,1.452-1.402,1.468s0.616-0.607,1.39-1.395 c0.692-0.704,1.587-1.615,2.722-2.772c1.821-1.872,3.513-3.61,5.104-5.246c0.771-0.792,2.185-1.868,3.234-2.212 c1.862-0.611,3.771-0.674,5.554,0.181c0.996,0.478,0.898,1.587,0.004,2.233C17.52,8.957,12.71,14.773,9.744,20.494 c-0.508,0.981-1.701,1.436-2.6,0.794C5.321,19.985,4.057,18.122,4.366,15.616z">
                                    </path>
                                    <path
                                        d="M29.392,20.977c-1.192,0.152-1.515,1.404-1.55,2.44c-0.028,0.797,0.318,2.496,1.453,2.351 c1.192-0.151,1.514-1.403,1.551-2.44C30.818,22.498,30.539,20.832,29.392,20.977z M29.188,25.304 c-0.511-0.336-0.627-1.167-0.687-1.716c-0.03-0.286,0.138-2.713,0.997-2.147c0.588,0.386,0.674,1.379,0.696,2.006 C30.177,23.823,29.968,25.817,29.188,25.304z">
                                    </path>
                                    <path
                                        d="M35.729,18.779c-1.108,0.141-1.364,1.566-1.396,2.452c-0.034,0.992,0.398,2.431,1.612,2.276 c1.108-0.141,1.363-1.566,1.396-2.451C37.307,20.07,36.985,18.619,35.729,18.779z M35.684,23.078 c-0.592-0.389-0.676-1.396-0.697-2.022c-0.013-0.342,0.224-2.361,1.008-1.847c0.591,0.389,0.676,1.396,0.697,2.022 C36.68,21.561,36.483,23.603,35.684,23.078z">
                                    </path>
                                    <path
                                        d="M15.634,22.863c0.013,0.008,0.034-0.005,0.056-0.03c0.023-0.028,0.005-0.049-0.029-0.027 C15.625,22.83,15.618,22.855,15.634,22.863z">
                                    </path>
                                    <path
                                        d="M34.321,11.939c-0.02-0.006-0.15,0.101-0.29,0.239c-0.141,0.138-0.229,0.245-0.197,0.239 c0.032-0.005,0.163-0.112,0.292-0.239C34.254,12.051,34.342,11.944,34.321,11.939z">
                                    </path>
                                    <path
                                        d="M28.897,4.135c0.033-0.013,0.246-0.209,0.476-0.439c0.231-0.229,0.308-0.467,0.167-0.521 c-0.14-0.054-0.816,0.477-1.51,1.18c-0.693,0.704-0.806,0.927-0.234,0.523C28.367,4.475,28.865,4.149,28.897,4.135z">
                                    </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                    {{ translate('Mailchimp') }}
                </button>
                <button
                    class="tablinks btn b-outline btn-primary-outline border-primary-200 justify-start !grow shrink-0 lg:w-full text-sm !text-gray-500 dark:!text-white hover:!text-primary hover:!bg-primary-200 dark:hover:!bg-dark-icon [&.active]:bg-primary-200 dark:[&.active]:bg-dark-icon [&.active]:border-transparent [&.active]:!text-primary dk-theme-card-square ac-transition"
                    onclick="openStep(event, 'social')">
                    <i class="ri-share-line text-inherit"></i>
                    {{ translate('Social') }}
                </button>
                <button
                    class="tablinks btn b-outline btn-primary-outline border-primary-200 justify-start !grow shrink-0 lg:w-full text-sm !text-gray-500 dark:!text-white hover:!text-primary hover:!bg-primary-200 dark:hover:!bg-dark-icon [&.active]:bg-primary-200 dark:[&.active]:bg-dark-icon [&.active]:border-transparent [&.active]:!text-primary dk-theme-card-square ac-transition"
                    onclick="openStep(event, 'home-setting')">
                    <i class="ri-pages-line text-inherit"></i>
                    {{ translate('Home Setting') }}
                </button>

                <button
                    class="tablinks btn b-outline btn-primary-outline border-primary-200 justify-start !grow shrink-0 lg:w-full text-sm !text-gray-500 dark:!text-white hover:!text-primary hover:!bg-primary-200 dark:hover:!bg-dark-icon [&.active]:bg-primary-200 dark:[&.active]:bg-dark-icon [&.active]:border-transparent [&.active]:!text-primary dk-theme-card-square ac-transition"
                    onclick="openStep(event, 'poster-settings')">
                    <i class="ri-advertisement-line text-inherit"></i>
                    {{ translate('Poster Settings') }}
                </button>

                <button
                    class="tablinks btn b-outline btn-primary-outline border-primary-200 justify-start !grow shrink-0 lg:w-full text-sm !text-gray-500 dark:!text-white hover:!text-primary hover:!bg-primary-200 dark:hover:!bg-dark-icon [&.active]:bg-primary-200 dark:[&.active]:bg-dark-icon [&.active]:border-transparent [&.active]:!text-primary dk-theme-card-square ac-transition"
                    onclick="openStep(event, 'footer')">
                    <i class="ri-pages-line text-inherit"></i>
                    {{ translate('Footer') }}
                </button>
                @can('menu.custom-script')
                    <button
                        class="tablinks btn b-outline btn-primary-outline border-primary-200 justify-start !grow shrink-0 lg:w-full text-sm !text-gray-500 dark:!text-white hover:!text-primary hover:!bg-primary-200 dark:hover:!bg-dark-icon [&.active]:bg-primary-200 dark:[&.active]:bg-dark-icon [&.active]:border-transparent [&.active]:!text-primary dk-theme-card-square ac-transition"
                        onclick="openStep(event, 'custom-script')">
                        <i class="ri-code-s-slash-line text-inherit"></i>
                        {{ translate('Custom Code') }}
                    </button>
                @endcan
            </div>

        </div>
        <!-- TAB CONTENTS -->
        <div class="grow">
            <!-- START GENERAL SETTINGS -->
            <div id="generalSetting" class="tabcontent card block">

                <h6 class="leading-none text-xl font-semibold text-heading"> {{ translate('General Settings') }} </h6>
                @php
                    $setting = get_theme_option(key: 'general') ?? [];
                @endphp
                <form enctype="multipart/form-data" class="add_setting mt-7" method="POST"
                    action="{{ route('theme.setting') }}" data-key="general">
                    @csrf
                    <div class="grid grid-cols-2 gap-x-4 gap-y-5 mt-0">
                        <div class="col-span-full xl:col-auto leading-none">
                            <div class="leading-none">
                                <label class="form-label">{{ translate('Email') }}</label>
                                <input type="text" name="email" class="form-input"
                                    value="{{ $setting['email'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-span-full xl:col-auto leading-none">
                            <div class="leading-none">
                                <label class="form-label">{{ translate('Second Email') }}</label>
                                <input type="text" name="second_email" class="form-input"
                                    value="{{ $setting['second_email'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-span-full xl:col-auto leading-none">
                            <div class="leading-none">
                                <label class="form-label">{{ translate('Phone') }}</label>
                                <input type="text" name="phone" class="form-input"
                                    value="{{ $setting['phone'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-span-full xl:col-auto leading-none">
                            <div class="leading-none">
                                <label class="form-label">{{ translate('Second Phone') }}</label>
                                <input type="text" name="second_phone" class="form-input"
                                    value="{{ $setting['second_phone'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-span-full xl:col-auto leading-none">
                            <div class="leading-none">
                                <label class="form-label">{{ translate('Address') }}</label>
                                <input type="text" name="address" class="form-input"
                                    value="{{ $setting['address'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-span-full xl:col-auto leading-none">
                            <div class="leading-none">
                                <label class="form-label">{{ translate('Office Hours') }}</label>
                                <input type="text" name="office_hours" class="form-input"
                                    value="{{ $setting['office_hours'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-span-full xl:col-auto leading-none">
                            <div class="leading-none">
                                <label class="form-label">{{ translate('Support Hours') }}</label>
                                <input type="text" name="support_hours" class="form-input"
                                    value="{{ $setting['support_hours'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-span-full xl:col-auto leading-none">
                            <div class="leading-none">
                                <label class="form-label">{{ translate('App Store Link') }}</label>
                                <input type="text" name="app_store_link" class="form-input"
                                    value="{{ $setting['app_store_link'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-span-full xl:col-auto leading-none">
                            <div class="leading-none">
                                <label class="form-label">{{ translate('Play Store Link') }}</label>
                                <input type="text" name="play_store_link" class="form-input"
                                    value="{{ $setting['play_store_link'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-span-full">
                            <div class="leading-none flex items-center gap-3">
                                <label for="multiple_theme" class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="multiple_theme"
                                        {{ isset($setting['is_multiple_theme']) && $setting['is_multiple_theme'] == 'on' ? 'checked' : '' }}
                                        name="is_multiple_theme" class="appearance-none peer">
                                    <span class="switcher switcher-primary-solid"></span>
                                </label>
                                <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                                    {{ translate('Would you like support for users to switch between multiple themes on your website?') }}
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
            <!-- START LOGO SETTINGS -->
            <div id="logo" class="tabcontent card hidden">
                <h6 class="leading-none text-xl font-semibold text-heading">
                    {{ translate('Upload Logo & Favicon') }}
                </h6>
                @php
                    $logo =
                        get_theme_option(key: 'theme_logo', theme_slug: active_theme_slug()) ??
                        (get_theme_option(key: 'theme_logo') ?? []);
                    $formKey =
                        active_theme_slug() == 'default'
                            ? 'theme_logo'
                            : 'theme_logo_' . key_snake_case(active_theme_slug());
                @endphp
                <form enctype="multipart/form-data" class="add_setting mt-7" method="POST"
                    action="{{ route('theme.setting') }}" data-key="{{ $formKey }}">
                    @csrf
                    <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                        <div class="col-span-full xl:col-auto leading-none">
                            <label class="form-label"> {{ translate('Theme Logo') }}
                                (100 x 35)</label>
                            <label for="imgageTheme"
                                class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                <input type="file" class="dropzone theme-setting-image" hidden id="imgageTheme">
                                <input type="hidden" name="logo" id="oldFile"
                                    value="{{ $logo['logo'] ?? '' }}">
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
                                        @if (isset($logo['logo']) && fileExists('lms/theme-options', $logo['logo']) == true && $logo['logo'] !== '')
                                            <div class="img-thumb-wrapper max-w-24 max-h-24"> <button
                                                    class="remove text-danger"> <i
                                                        class="ri-close-line text-inherit text-[13px]"></i>
                                                </button>
                                                <img id="preview_img" width="auto"
                                                    src="{{ asset('storage/lms/theme-options/' . $logo['logo']) }}" />
                                            </div>
                                        @else
                                            <div class="img-thumb-wrapper max-w-24 max-h-24">
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
                        <div class="col-span-full xl:col-auto leading-none">
                            <label class="form-label">
                                {{ translate('Theme Favicon') }}({{ translate('16') }}x{{ translate('16') }})</label>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="imgageFavicon"
                                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                    <input type="file" class="dropzone theme-setting-image" hidden
                                        id ="imgageFavicon">
                                    <input type="hidden" name="favicon" id="oldFile"
                                        value="{{ isset($logo['favicon']) }}">
                                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                        <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                                            alt="file-icon" class="size-8 lg:size-auto">
                                        <div class="text-gray-500 dark:text-dark-text mt-2">
                                            {{ translate('Choose file') }}</div>
                                    </span>
                                </label>
                                <div class="preview-zone dropzone-preview">
                                    <div class="box box-solid">
                                        <div class="box-body flex items-center gap-2 flex-wrap">
                                            @if (isset($logo['favicon']) &&
                                                    fileExists($folder = 'lms/theme-options', $fileName = $logo['favicon']) == true &&
                                                    $logo['favicon'] !== '')
                                                <div class="img-thumb-wrapper max-w-24 max-h-24 !size-10 flex-center">
                                                    <button class="remove text-danger"> <i
                                                            class="ri-close-line text-inherit text-[13px]"></i>
                                                    </button>
                                                    <img id="preview_img" width="16" height="16"
                                                        src="{{ asset('storage/lms/theme-options/' . $logo['favicon']) }}" />
                                                </div>
                                            @else
                                                <div class="img-thumb-wrapper max-w-24 max-h-24">
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
                            <label class="form-label"> {{ translate('Footer Logo') }}
                                ({{ translate('160') }}x{{ translate('45') }})</label>
                            <label for="footerLogo"
                                class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                <input type="file" class="dropzone theme-setting-image" hidden id="footerLogo">
                                <input type="hidden" name="footer_logo" id="oldFile"
                                    value="{{ $logo['footer_logo'] ?? '' }}">
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
                                        @if (isset($logo['footer_logo']) &&
                                                fileExists( 'lms/theme-options',  $logo['footer_logo']) == true &&
                                                $logo['footer_logo'] !== '')
                                            <div class="img-thumb-wrapper max-w-24 max-h-24"> <button
                                                    class="remove text-danger"> <i
                                                        class="ri-close-line text-inherit text-[13px]"></i>
                                                </button>
                                                <img id="preview_img" width="auto"
                                                    src="{{ asset('storage/lms/theme-options/' . $logo['footer_logo']) }}" />
                                            </div>
                                        @else
                                            <div class="img-thumb-wrapper max-w-24 max-h-24">
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
                    <div class="flex justify-end mt-10">
                        <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </form>
            </div>
            <!-- START GDPR COOKIE SETTINGS -->
            <div id="cookie" class="tabcontent card hidden">
                <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('GDPR Cookie Settings') }}
                </h6>
                @php
                    $cookie =
                        get_theme_option('gdpr_cookie' . active_language()) ?:
                        get_theme_option('gdpr_cookieen') ?? get_theme_option('gdpr_cookie' . app('default_language'));
                @endphp
                <form enctype="multipart/form-data" class="add_setting mt-7" method="POST"
                    action="{{ route('theme.setting') }}" data-key="gdpr_cookie{{ active_language() }}">
                    @csrf
                    <div class="leading-none">
                        <label class="form-label">{{ translate('GDPR Title') }}</label>
                        <input type="text" class="form-input" name="gdpr_title"
                            value="{{ $cookie['gdpr_title'] ?? '' }}">
                    </div>
                    <div class="leading-none mt-6">
                        <label class="form-label">{{ translate('GDPR Description') }}</label>
                        <textarea name="gdpr_description" class="summernote form-input">{!! clean($cookie['gdpr_description'] ?? '') !!}</textarea>
                    </div>
                    <div class="flex items-center gap-2 mt-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="appearance-none peer" name="status"
                                {{ (isset($cookie['status']) && $cookie['status']) == 'on' ? 'checked' : '' }}>
                            <span class="switcher switcher-primary-solid"></span>
                        </label>
                        <div class="form-label m-0">{{ translate('Enable') }}/{{ translate('Disable') }}</div>
                    </div>
                    <div class="flex justify-end mt-10">
                        <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </form>
            </div>
            <!-- START TWAK CHAT SETTINGS -->
            <div id="tawk-chat" class="tabcontent card hidden">
                <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Twak Chat Settings') }}</h6>
                @php
                    $tawkChat = get_theme_option(key: 'tawk_chat');
                @endphp
                <form enctype="multipart/form-data" class="add_setting mt-7" method="POST"
                    action="{{ route('theme.setting') }}" data-key="tawk_chat">
                    @csrf
                    <div class="leading-none">
                        <label class="form-label"> {{ translate('Tawk Url') }}</label>
                        <input type="text" class="form-input" name="url"
                            value="{{ $tawkChat['url'] ?? '' }}">
                    </div>
                    <div class="flex items-center gap-2 leading-none mt-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="appearance-none peer" name="status"
                                {{ (isset($tawkChat['status']) && $tawkChat['status']) == 'on' ? 'checked' : '' }}>
                            <span class="switcher switcher-primary-solid"></span>
                        </label>
                        <div class="form-label m-0"> {{ translate('Enable') }}/{{ translate('Disable') }} </div>
                    </div>
                    <div class="block mt-4">
                        <a href="https://www.tawk.to/" class="text-primary underline text-sm p-2" target="_blank">
                            {{ translate('Go to Tawk') }}</a>
                    </div>
                    <div class="flex justify-end mt-10">
                        <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </form>
            </div>

            <div id="mailchimp" class="tabcontent card hidden">
                <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Mailchimp Settings') }}
                </h6>
                @php
                    $mailchimp = get_theme_option(key: 'mailchimp');
                @endphp
                <form enctype="multipart/form-data" class="add_setting mt-7" method="POST"
                    action="{{ route('theme.setting') }}" data-key="mailchimp">
                    @csrf
                    <div class="leading-none">
                        <label class="form-label"> {{ translate('Api Key') }}</label>
                        <input type="text" class="form-input" name="api_key"
                            value="{{ $mailchimp['api_key'] ?? '' }}">
                    </div>

                    <div class="leading-none mt-6">
                        <label class="form-label"> {{ translate('List Id') }}</label>
                        <input type="text" class="form-input" name="list_id"
                            value="{{ $mailchimp['list_id'] ?? '' }}">
                    </div>


                    <div class="flex items-center gap-2 leading-none mt-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="appearance-none peer" name="status"
                                {{ (isset($mailchimp['status']) && $mailchimp['status']) == 'on' ? 'checked' : '' }}>
                            <span class="switcher switcher-primary-solid"></span>
                        </label>
                        <div class="form-label m-0"> {{ translate('Enable') }}/{{ translate('Disable') }} </div>
                    </div>
                    <div class="mt-4">
                        <a href="https://mailchimp.com/" class="text-primary underline text-sm p-2" target="_blank">
                            {{ translate('Go to Mailchimp') }}</a>
                    </div>
                    <div class="flex justify-end mt-10">
                        <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </form>
            </div>


            <!-- START CUSTOM CSS & JS SETTINGS -->
            <div id="custom-script" class="tabcontent card hidden">
                <h6 class="leading-none text-xl font-semibold text-heading">
                    {{ translate('Custom Css & Javascript Settings') }}
                </h6>
                @php
                    $script = get_theme_option(key: 'custom_script');
                @endphp
                <form enctype="multipart/form-data" class="add_setting mt-7" method="POST"
                    action="{{ route('theme.setting') }}" data-key="custom_script">
                    @csrf
                    <div class="leading-none">
                        <label class="form-label"> {{ translate('Custom CSS') }} </label>
                        <textarea name="custom_css" class="editorContainer">{!! $script['custom_css'] ?? '' !!}</textarea>
                    </div>
                    <div class="leading-none mt-6">
                        <label class="form-label"> {{ translate('Custom JS') }} </label>
                        <textarea name="custom_js" class="editorContainer">{!! $script['custom_js'] ?? '' !!}</textarea>
                    </div>
                    <div class="flex justify-end mt-10">
                        <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </form>
            </div>
            <!-- START SOCIAL MEDIA SETTINGS -->
            <div id="social" class="tabcontent card hidden">
                <form enctype="multipart/form-data" class="add_setting" method="POST"
                    action="{{ route('theme.setting') }}" data-key="social">
                    @php
                        $socials = get_theme_option(key: 'socials', parent_key: 'social') ?? [];
                    @endphp
                    @csrf
                    <div class="flex-center-between">
                        <h6 class="leading-none text-xl font-semibold text-heading">
                            {{ translate('Social Media Settings') }}
                        </h6>
                        <button type="button"
                            class="btn b-solid btn-primary-solid btn-sm dk-theme-card-square add-item">
                            {{ translate('Add') }}
                        </button>
                    </div>
                    <div class="social-area total-length mt-7" data-length="{{ $socials ? count($socials) : 0 }}">
                        @if (!empty($socials))
                            @foreach ($socials as $key => $social)
                                <div
                                    class="flex items-end gap-5 mt-7 group-item p-4 dk-border-one rounded-10 dk-theme-card-square">
                                    <div class="grid grid-cols-2 gap-4 grow">
                                        <div class="col-span-full xl:col-auto leading-none">
                                            <label class="form-label">
                                                {{ translate('Icon with class name') }}
                                            </label>
                                            <input type="text" name="socials[{{ $key }}][icon]"
                                                class="form-input" value="{{ $social['icon'] ?? '' }}">
                                        </div>
                                        <div class="col-span-full xl:col-auto leading-none">
                                            <label class="form-label">{{ translate('Link Url') }}</label>
                                            <input type="text" class="form-input"
                                                name="socials[{{ $key }}][url]"
                                                value="{{ $social['url'] ?? '' }}">
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="btn b-solid btn-danger-solid dk-theme-card-square max-h-fit shrink-0 delete-item">
                                        {{ translate('Delete') }}
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="flex justify-end mt-10">
                        <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </form>
            </div>
            <!-- START HOME SETTINGS -->
            <div id="home-setting" class="tabcontent hidden">
                <div class="card">
                    <h6 class="leading-none text-xl font-semibold text-heading">
                        {{ translate('Home Page Settings') }}
                    </h6>
                </div>
                <!-- COUNTER SECTION -->
                <div class="card">
                    <h6 class="leading-none text-xl font-semibold text-heading">
                        {{ translate('Counter Section') }}
                    </h6>
                    <div class="counter-section mt-7">
                        @php
                            $counter = get_theme_option(key: 'counter') ?? [];
                        @endphp
                        <form enctype="multipart/form-data" class="add_setting" method="POST"
                            action="{{ route('theme.setting') }}" data-key="counter">
                            @csrf

                            <div class="grid grid-cols-2 gap-x-4 gap-y-6 mt-7 group-item">

                                <div class="col-span-full xl:col-auto leading-none">
                                    <label class="form-label">{{ translate('Total Experience') }}</label>
                                    <input type="text" name="total_experience"
                                        value="{{ $counter['total_experience'] ?? '' }}" class="form-input">
                                </div>


                            </div>
                            <div class="flex justify-end mt-10">
                                <button type="submit"
                                    class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                                    {{ translate('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- About Us Section -->
                <div class="card">
                    <h6 class="leading-none text-xl font-semibold text-heading">
                        {{ translate('About Us Section') }}
                    </h6>
                    <div class="counter-section mt-7">
                        @php
                            $aboutUs =
                                get_theme_option('about_us' . active_language()) ?:
                                get_theme_option('about_usen') ??
                                    get_theme_option('about_us' . app('default_language'));
                        @endphp
                        <form enctype="multipart/form-data" class="add_setting" method="POST"
                            action="{{ route('theme.setting') }}" data-key="about_us{{ active_language() }}">
                            @csrf

                            <div class="grid grid-cols-2 gap-x-4 gap-y-6 mt-7 group-item">
                                <div class="col-span-full xl:col-auto leading-none">
                                    <label class="form-label">{{ translate('Title') }}</label>
                                    <input type="text" name="title" value="{{ $aboutUs['title'] ?? '' }}"
                                        class="form-input">
                                </div>

                                <div class="col-span-full xl:col-auto leading-none">
                                    <label class="form-label">{{ translate('Highlight title') }}</label>
                                    <input type="text" name="highlight_title"
                                        value="{{ $aboutUs['highlight_title'] ?? '' }}" class="form-input">
                                </div>
                                <div class="col-span-full xl:col-auto leading-none">
                                    <label class="form-label">{{ translate('Short Description') }}</label>
                                    <input type="text" name="short_description"
                                        value="{{ $aboutUs['short_description'] ?? '' }}" class="form-input">
                                </div>
                                <div class="col-span-full xl:col-auto leading-none">
                                    <label class="form-label">{{ translate('Active User') }}</label>
                                    <input type="text" name="active_user"
                                        value="{{ $aboutUs['active_user'] ?? '' }}" class="form-input">
                                </div>
                                <div class="col-span-full xl:col-auto leading-none">
                                    <label
                                        class="form-label">{{ translate('Active User Short Description') }}</label>
                                    <input type="text" name="active_user_short_des"
                                        value="{{ $aboutUs['active_user_short_des'] ?? '' }}" class="form-input">
                                </div>
                                <div class="col-span-full xl:col-auto leading-none">
                                    <label class="form-label">{{ translate('Satisfied User') }}</label>
                                    <input type="text" class="form-input" name="satisfied_user"
                                        value="{{ $aboutUs['satisfied_user'] ?? '' }}">
                                </div>
                                <div class="col-span-full xl:col-auto leading-none">
                                    <label
                                        class="form-label">{{ translate('Satisfied User Short Description') }}</label>
                                    <input type="text" class="form-input" name="satisfied_user_short_des"
                                        value="{{ $aboutUs['satisfied_user_short_des'] ?? '' }}">
                                </div>

                                <div class="col-span-full leading-none">
                                    <label class="form-label">{{ translate('Additional Description') }}</label>
                                    <textarea type="text" class="summernote form-input" name="add_description">
                                        {{ $aboutUs['add_description'] ?? '' }}
                                    </textarea>
                                </div>

                                @php
                                    $sliderImgDigital = $aboutUs['banner_img_digital'] ?? null;
                                    $sliderImgElearning = $aboutUs['banner_img_elearning'] ?? null;
                                    $sliderImgLms = $aboutUs['banner_img_lms'] ?? null;
                                    $sliderImgKindergarten = $aboutUs['banner_img_kindergarten'] ?? null;
                                @endphp

                                {{-- Banner Image digital Education --}}
                                <div class="col-span-full xl:col-auto leading-none">

                                    <label
                                        class="form-label">{{ translate('About Section Image For Digital Education') }}</label>
                                    <label for="bannerImageOne"
                                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                        <input type="file" class="dropzone theme-setting-image" hidden
                                            id="bannerImageOne">
                                        <input type="hidden" name="banner_img_digital" id="oldFile"
                                            value="{{ $sliderImgDigital ?? '' }}">

                                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                            <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                                                alt="file-icon" class="size-8 lg:size-auto">
                                            <div class="text-gray-500 mt-2">{{ translate('Choose file') }}</div>
                                        </span>
                                    </label>

                                    <div class="preview-zone dropzone-preview">
                                        <div class="box box-solid">
                                            <div class="box-body flex items-center gap-2 flex-wrap">
                                                @if (
                                                    $sliderImgDigital &&
                                                        fileExists($slider = 'lms/theme-options', $fileName = $sliderImgDigital) == true &&
                                                        $sliderImgDigital !== '')
                                                    <div class="img-thumb-wrapper">
                                                        <img id="preview_img" width="120"
                                                            src="{{ asset('storage/lms/theme-options/' . $sliderImgDigital) }}" />
                                                    </div>
                                                @endif
                                                <img id="preview_img" src="" width="120">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Banner Image E-Learnning --}}
                                <div class="col-span-full xl:col-auto leading-none">

                                    <label
                                        class="form-label">{{ translate('About Section Image For E-learning Education') }}</label>
                                    <label for="bannerImageThree"
                                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                        <input type="file" class="dropzone theme-setting-image" hidden
                                            id="bannerImageThree">
                                        <input type="hidden" name="banner_img_elearning" id="oldFile"
                                            value="{{ $sliderImgElearning ?? '' }}">
                                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                            <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                                                alt="file-icon" class="size-8 lg:size-auto">
                                            <div class="text-gray-500 mt-2">{{ translate('Choose file') }}</div>
                                        </span>
                                    </label>

                                    <div class="preview-zone dropzone-preview">
                                        <div class="box box-solid">
                                            <div class="box-body flex items-center gap-2 flex-wrap">
                                                @if (
                                                    $sliderImgElearning &&
                                                        fileExists($slider = 'lms/theme-options', $fileName = $sliderImgElearning) == true &&
                                                        $sliderImgElearning !== '')
                                                    <div class="img-thumb-wrapper">
                                                        <img id="preview_img" width="120"
                                                            src="{{ asset('storage/lms/theme-options/' . $sliderImgElearning) }}" />
                                                    </div>
                                                @endif
                                                <img id="preview_img" src="" width="120">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Banner Image LMS Education --}}
                                <div class="col-span-full xl:col-auto leading-none">

                                    <label
                                        class="form-label">{{ translate('About Section Image For LMS Education') }}</label>
                                    <label for="bannerImageFour"
                                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                        <input type="file" class="dropzone theme-setting-image" hidden
                                            id="bannerImageFour">
                                        <input type="hidden" name="banner_img_lms" id="oldFile"
                                            value="{{ $sliderImgLms ?? null }}">
                                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                            <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                                                alt="file-icon" class="size-8 lg:size-auto">
                                            <div class="text-gray-500 mt-2">
                                                {{ translate('Choose file') }}
                                            </div>
                                        </span>
                                    </label>

                                    <div class="preview-zone dropzone-preview">
                                        <div class="box box-solid">
                                            <div class="box-body flex items-center gap-2 flex-wrap">
                                                @if (
                                                    $sliderImgLms &&
                                                        fileExists($slider = 'lms/theme-options', $fileName = $sliderImgLms) == true &&
                                                        $sliderImgLms !== '')
                                                    <div class="img-thumb-wrapper">
                                                        <img id="preview_img" width="120"
                                                            src="{{ asset('storage/lms/theme-options/' . $sliderImgLms) }}" />
                                                    </div>
                                                @endif
                                                <img id="preview_img" src="" width="120">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Banner Image Kindergarten --}}
                                <div class="col-span-full xl:col-auto leading-none">

                                    <label
                                        class="form-label">{{ translate('About Section Image For Kindergarten') }}</label>
                                    <label for="bannerImageTwo"
                                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">

                                        <input type="file" class="dropzone theme-setting-image" hidden
                                            id="bannerImageTwo">

                                        <input type="hidden" name="banner_img_kindergarten" id="oldFile"
                                            value="{{ $sliderImgKindergarten ?? '' }}">

                                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                            <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                                                alt="file-icon" class="size-8 lg:size-auto">
                                            <div class="text-gray-500 mt-2">
                                                {{ translate('Choose file') }}
                                            </div>
                                        </span>
                                    </label>

                                    <div class="preview-zone dropzone-preview">
                                        <div class="box box-solid">
                                            <div class="box-body flex items-center gap-2 flex-wrap">
                                                @if (
                                                    $sliderImgKindergarten &&
                                                        fileExists($slider = 'lms/theme-options', $fileName = $sliderImgKindergarten) == true &&
                                                        $sliderImgKindergarten !== '')
                                                    <div class="img-thumb-wrapper">
                                                        <img id="preview_img" width="120"
                                                            src="{{ asset('storage/lms/theme-options/' . $sliderImgKindergarten) }}" />
                                                    </div>
                                                @endif
                                                <img id="preview_img" src="" width="120">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="flex justify-end mt-10">
                                <button type="submit"
                                    class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                                    {{ translate('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Poster Settings --}}
            <div id="poster-settings" class="tabcontent hidden">
                <!-- Poster Sectin -->
                <div class="poster-section cardcc">
                    <div class="card flex-center-between">
                        <h6 class="leading-none text-xl font-semibold text-heading">
                            {{ translate('Poster Section') }}
                        </h6>
                        <button type="button"
                            class="btn b-solid btn-primary-solid btn-sm dk-theme-card-square add-poster">
                            {{ translate('Add New') }}
                        </button>
                    </div>
                    <div class="banner-section">
                        @php
                            $poster =
                                get_theme_option('poster' . active_language()) ?:
                                get_theme_option('posteren') ?? get_theme_option('postere' . app('default_language'));
                        @endphp
                        <form enctype="multipart/form-data" class="add_setting" method="POST"
                            action="{{ route('theme.setting') }}" data-key="poster{{ active_language() }}">
                            @csrf

                            <div class="poster-area"
                                data-length="{{ isset($poster['poster']) ? count($poster['poster']) : 0 }}">

                                @if (isset($poster['poster']))
                                    @foreach ($poster['poster'] as $key => $poster)
                                        <div class="card grid grid-cols-2 gap-x-4 gap-y-6 poster-item">
                                            <div class="col-span-full 2xl:col-auto leading-none">
                                                <label class="form-label">{{ translate('Title') }}</label>
                                                <input type="text" name="poster[{{ $key }}][title]"
                                                    class="form-input" value="{{ $poster['title'] ?? '' }}">
                                            </div>
                                            <div class="col-span-full 2xl:col-auto leading-none">
                                                <label class="form-label">{{ translate('Description') }}</label>
                                                <input type="text"
                                                    name="poster[{{ $key }}][description]"
                                                    class="form-input" value="{{ $poster['description'] ?? '' }}">
                                            </div>
                                            <div class="col-span-full 2xl:col-auto leading-none">
                                                <label class="form-label">{{ translate('Button Text') }}</label>
                                                <input type="text"
                                                    name="poster[{{ $key }}][button_label]"
                                                    class="form-input" value="{{ $poster['button_label'] ?? '' }}">
                                            </div>
                                            <div class="col-span-full 2xl:col-auto leading-none">
                                                <label class="form-label">{{ translate('Button url') }}</label>
                                                <input type="text" class="form-input"
                                                    name="poster[{{ $key }}][button_link]"
                                                    value="{{ $poster['button_link'] ?? '' }}">
                                            </div>
                                            @php
                                                $posterImg = $poster['poster_img'] ?? null;

                                            @endphp
                                            <div class="col-span-full leading-none">
                                                <label
                                                    class="form-label">{{ translate('Poster Background Image') }}</label>
                                                <label for="bannerImage{{ $key }}"
                                                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">

                                                    <input type="file" class="dropzone theme-setting-image" hidden
                                                        id="bannerImage{{ $key }}">

                                                    <input type="hidden"
                                                        name="poster[{{ $key }}][poster_img]"
                                                        id="oldFile" value="{{ $posterImg ?? '' }}">

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
                                                            @if ($posterImg && fileExists($poster = 'lms/theme-options', $fileName = $posterImg) == true && $posterImg !== '')
                                                                <div class="img-thumb-wrapper">
                                                                    <img id="preview_img" width="120"
                                                                        src="{{ asset('storage/lms/theme-options/' . $posterImg) }}" />
                                                                </div>
                                                            @endif
                                                            <img id="preview_img" src="" width="120">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button"
                                                class="btn b-solid btn-danger-solid dk-theme-card-square max-h-fit shrink-0 delete-poster-item">
                                                {{ translate('Delete') }}
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card grid grid-cols-2 gap-x-4 gap-y-6 poster-item">
                                        <div class="col-span-full 2xl:col-auto leading-none">
                                            <label class="form-label">{{ translate('Title') }}</label>
                                            <input type="text" name="poster[0][title]" class="form-input"
                                                value="{{ $poster['title'] ?? '' }}">
                                        </div>
                                        <div class="col-span-full 2xl:col-auto leading-none">
                                            <label class="form-label">{{ translate('Description') }}</label>
                                            <input type="text" name="poster[0][description]" class="form-input"
                                                value="{{ $poster['description'] ?? '' }}">
                                        </div>
                                        <div class="col-span-full 2xl:col-auto leading-none">
                                            <label class="form-label">{{ translate('Button Label') }}</label>
                                            <input type="text" name="poster[0][button_label]" class="form-input"
                                                value="{{ $poster['button_label'] ?? '' }}">
                                        </div>
                                        <div class="col-span-full 2xl:col-auto leading-none">
                                            <label class="form-label">{{ translate('Button Link') }}</label>
                                            <input type="text" class="form-input" name="poster[0][button_link]"
                                                value="{{ $poster['button_link'] ?? '' }}">
                                        </div>
                                        @php
                                            $posterImg = $poster['poster_img'] ?? null;
                                        @endphp
                                        <div class="col-span-full leading-none">
                                            <label
                                                class="form-label">{{ translate('Poster Background Image') }}</label>
                                            <label for="bannerImage0"
                                                class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                                                <input type="file" class="dropzone theme-setting-image" hidden
                                                    id="bannerImage0">
                                                <input type="hidden" name="poster[0][poster_img]" id="oldFile"
                                                    value="{{ $posterImg ?? '' }}">
                                                <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                                    <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                                                        alt="file-icon" class="size-8 lg:size-auto">
                                                    <div class="text-gray-500 dark:text-dark-text mt-2">
                                                        {{ translate('Choose file') }}</div>
                                                </span>
                                            </label>
                                            <div class="preview-zone dropzone-preview">
                                                <div class="box box-solid">
                                                    <div class="box-body flex items-center gap-2 flex-wrap">
                                                        @if ($posterImg && fileExists('lms/theme-options', $posterImg) == true && $posterImg !== '')
                                                            <div class="img-thumb-wrapper">
                                                                <img id="preview_img" width="120"
                                                                    src="{{ asset('storage/lms/theme-options/' . $posterImg) }}" />
                                                            </div>
                                                        @endif
                                                        <img id="preview_img" src="" width="120">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="flex justify-end mt-10">
                                <button type="submit"
                                    class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                                    {{ translate('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- START FOOTER SETTINGS -->
            <div id="footer" class="tabcontent hidden">
                <div class="footer-top">
                    @php
                        $top =
                            get_theme_option('footer_top' . active_language()) ?:
                            get_theme_option('footer_topen') ??
                                get_theme_option('footer_top' . app('default_language'));
                    @endphp
                    <form enctype="multipart/form-data" class="add_setting" method="POST"
                        action="{{ route('theme.setting') }}" data-key="footer_top{{ active_language() }}">
                        @csrf
                        <!-- START FOOTER WIDGET ONE -->
                        <div class="card">
                            <h6 class="leading-none text-xl font-semibold text-heading">
                                {{ translate('Footer Widget One') }}</h6>
                            <div class="group-field mt-7">
                                <label class="form-label">{{ translate('Title') }}</label>
                                <input type="text" name="one_title" value="{{ $top['one_title'] ?? '' }}"
                                    class="form-input">
                            </div>
                            <div class="flex items-center gap-2 group-field mt-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="appearance-none peer" name="one_status"
                                        {{ isset($top['one_status']) ? 'checked' : '' }}>
                                    <span class="switcher switcher-primary-solid"></span>
                                </label>
                                <div class="form-label m-0">{{ translate('Enable') }}/{{ translate('Disable') }}
                                </div>
                            </div>
                            <div class="flex items-center gap-2 group-field mt-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="appearance-none peer" name="one_social_menu"
                                        {{ isset($top['one_social_menu']) ? 'checked' : '' }}>
                                    <span class="switcher switcher-primary-solid"></span>
                                </label>
                                <div class="form-label m-0">{{ translate('Allow Social Menu') }}</div>
                            </div>
                        </div>
                        <!-- START FOOTER WIDGET TWO -->
                        <div class="grid grid-cols-12 gap-x-4 group-item">
                            <!-- START FOOTER WIDGET TWO -->
                            <div class="col-span-full xl:col-span-6 card">
                                <h6 class="leading-none text-xl font-semibold text-heading">
                                    {{ translate('Footer Widget Two') }}</h6>
                                <div class="group-field mt-7">
                                    <label class="form-label">{{ translate('Title') }}</label>
                                    <input type="text" name="two_title" value="{{ $top['two_title'] ?? '' }}"
                                        class="form-input">
                                </div>
                                <div class="group-field mt-6">
                                    <label class="form-label">{{ translate('Content') }}</label>
                                    <textarea name="two_menu" class="summernote">{!! clean($top['two_menu'] ?? '') !!}</textarea>
                                </div>
                                <div class="flex items-center gap-2 group-field mt-6">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="appearance-none peer" name="two_status"
                                            {{ isset($top['two_status']) ? 'checked' : '' }}>
                                        <span class="switcher switcher-primary-solid"></span>
                                    </label>
                                    <div class="form-label m-0">
                                        {{ translate('Enable') }}/{{ translate('Disable') }}</div>
                                </div>
                            </div>
                            <!-- START FOOTER WIDGET THREE -->
                            <div class="col-span-full xl:col-span-6 card">
                                <h6 class="leading-none text-xl font-semibold text-heading">
                                    {{ translate('Footer Widget Three') }}</h6>
                                <div class="group-field mt-7">
                                    <label class="form-label">{{ translate('Title') }}</label>
                                    <input type="text" name="three_title"
                                        value="{{ $top['three_title'] ?? null }}" class="form-input">
                                </div>
                                <div class="group-field mt-6">
                                    <label class="form-label">{{ translate('Content') }}</label>
                                    <textarea name="three_menu" class="summernote">{!! clean($top['three_menu'] ?? '') !!}</textarea>
                                </div>
                                <div class="flex items-center gap-2 group-field mt-6">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="appearance-none peer" name="three_status"
                                            {{ isset($top['three_status']) ? 'checked' : '' }}>
                                        <span class="switcher switcher-primary-solid"></span>
                                    </label>
                                    <div class="form-label m-0">
                                        {{ translate('Enable') }}/{{ translate('Disable') }}</div>
                                </div>
                            </div>

                            <!-- START FOOTER WIDGET FIVE -->
                            <div class="col-span-full xl:col-span-12 card">
                                <h6 class="leading-none text-xl font-semibold text-heading">
                                    {{ translate('Footer Widget Four') }}</h6>
                                <div class="group-field mt-7">
                                    <label class="form-label">{{ translate('Title') }}</label>
                                    <input type="text" name="five_title"
                                        value="{{ $top['five_title'] ?? null }}" class="form-input">
                                </div>
                                <div class="group-field mt-6">
                                    <label class="form-label">{{ translate('Content') }}</label>
                                    <textarea name="five_menu" class="summernote">{!! clean($top['five_menu'] ?? '') !!}</textarea>
                                </div>
                                <div class="flex items-center gap-2 group-field mt-6">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="appearance-none peer" name="five_status"
                                            {{ isset($top['five_status']) ? 'checked' : '' }}>
                                        <span class="switcher switcher-primary-solid"></span>
                                    </label>
                                    <div class="form-label m-0">
                                        {{ translate('Enable') }}/{{ translate('Disable') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end mb-2">
                            <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                                {{ translate('Save') }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- START FOOTER BOTTOM -->
                <div class="footer-bottom card">
                    <h6 class="leading-none text-xl font-semibold text-heading">
                        {{ translate('Footer Bottom Settings') }}</h6>
                    @php
                        $bottom =
                            get_theme_option('footer_bottom' . active_language()) ?:
                            get_theme_option('footer_bottomen') ??
                                get_theme_option('footer_bottom' . app('default_language'));

                    @endphp
                    <form enctype="multipart/form-data" class="add_setting mt-7" method="POST"
                        action="{{ route('theme.setting') }}" data-key="footer_bottom{{ active_language() }}">
                        @csrf
                        <div class="grid grid-cols-2 gap-4 group-item">
                            <div class="col-span-full xl:col-auto leading-none">
                                <label class="form-label">{{ translate('Title') }}</label>
                                <textarea name="copy_right" class="summernote">{!! clean($bottom['copy_right'] ?? '') !!}</textarea>
                            </div>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label class="form-label">{{ translate('Menu Link List') }}</label>
                                <textarea name="menu" class="summernote">{!! clean($bottom['menu'] ?? '') !!}</textarea>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-6">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="appearance-none peer" name="status"
                                    {{ isset($bottom['status']) ? 'checked' : '' }}>
                                <span class="switcher switcher-primary-solid"></span>
                            </label>
                            <div class="form-label m-0">{{ translate('Enable') }}/{{ translate('Disable') }}</div>
                        </div>
                        <div class="flex justify-end mt-10">
                            <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                                {{ translate('Save') }}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <input type="hidden" id="imgUploadPath" value="{{ asset('lms/assets/images/icons/upload-file.svg') }}">
    <input type="hidden" id="imgUploadPathPoster" value="{{ asset('lms/assets/images/icons/upload-file.svg') }}">
</x-dashboard-layout>
