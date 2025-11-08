<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one 
        pageTitle="Success"
        pageName="Payment Success" 
    />
    <div class="bg-primary-100 container py-16 sm:py-24 lg:py-[120px]">
        <div class="size-full flex-center flex-col max-w-screen-sm mx-auto">
            <h6 class="area-title text-xl">{{ translate('Payment Success') }}</h6>
            <a href="{{ route('login') }}" aria-label="Go back to home"
                class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium text-[16px] md:text-[18px] mt-10">
                <i class="ri-arrow-left-line"></i>
                {{ translate('Go to Dashboard') }}
            </a>
        </div>
    </div>
</x-frontend-layout>
