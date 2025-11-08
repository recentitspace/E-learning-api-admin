@php

    $settings = [
        'class' => [
            'input_class' => 'form-input !bg-white rounded-full peer',
            'btn_class' =>
                'btn b-solid btn-primary-solid btn-lg !text-base !rounded-full font-bold !leading-none w-full',
        ],
        'btn' => [
            'text' => 'Submit Now',
            'is_show_icon' => false,
        ],
    ];
@endphp

<div class="relative pt-16 sm:pt-24 lg:pt-[120px] mt-16 sm:mt-24 lg:mt-[120px] overflow-hidden">
    <div class="container relative z-[1]">
        <div class="grid grid-cols-12 rounded-2xl overflow-hidden">
            <div class="col-span-full lg:col-span-7">
                <div class="bg-gradient-to-b from-[#FEFBF0] to-[#E6F3EB] px-5 py-8 xl:p-20 h-full">
                    <h2 class="area-title">
                        {{ translate('Apply For') }}
                        <span class="title-highlight-two">{{ translate('Admission') }}</span>
                    </h2>
                    <div class="area-description mt-3 line-clamp-2">
                        {{ translate('Our streamlined admission process makes it easy to enroll in courses that fit your career aspirations') }}
                    </div>
                    <x-theme::form.join-us.form :data="$settings" />
                </div>
            </div>
            <div class="col-span-full lg:col-span-5 hidden lg:block">
                <div class="p-0 m-0 aspect-[1/1.38] h-full overflow-hidden">
                    <img data-src="{{ asset('lms/frontend/assets/images/admission/admission-one.webp') }}"
                        alt="Admission banner" class="size-full object-cover">
                </div>
            </div>
        </div>
    </div>
    <!-- POSITIONAL ELEMENT -->
    <ul>
        <!-- TOP LEFT -->
        <li
            class="block size-[29vw] rounded-50 bg-[#D2EB1A]/15 blur-[200px] absolute top-0 xl:-top-20 right-0 rtl:right-auto rtl:left-0 xl:-right-20 rtl:xl:right-auto rtl:xl:-left-20 z-0">
        </li>
        <!-- TOP RIGHT -->
        <li
            class="block size-[29vw] rounded-50 bg-[#B326F4]/15 blur-[200px] absolute top-0 xl:-top-20 left-0 rtl:left-auto rtl:right-0 xl:-left-20 rtl:xl:left-auto rtl:xl:-right-20 z-0">
        </li>
    </ul>
</div>
